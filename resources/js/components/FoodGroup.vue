<template>
    <div class="w-full md:w-1/2 lg:w-1/3 xl:w-1/4 p-4">
        <div class="shadow p-4">
            <div class="flex mb-4">
                <h3 class="flex-grow mb-0">
                    <i class="text-xl pl-1" :class="iconClass" aria-hidden="true"></i>&nbsp;{{ food_group.name }}
                </h3>

                <div class="flex-shrink">
                    <a class="cursor-pointer block h-full px-2 py-1 hover:text-blue-500" @click="showOptimalStockModal = true">
                        <i :class="stockIconClass" aria-hidden="true"></i> {{ stock }} / {{ optimalStock }}
                    </a>

                    <modal :showing="showOptimalStockModal" @close="showOptimalStockModal = false">
                        <form v-on:submit.prevent="saveOptimalStock">
                            <div class="mb-6 flex flex-wrap">
                                <label for="optimal_stock">
                                    Adjust optimal stock for <i class="pl-1" :class="iconClass" aria-hidden="true"></i>
                                </label>
                                <input id="optimal_stock" type="number" name="optimal_stock" v-model="optimalStock">

                                <span class="hidden invalid-feedback font-bold" role="alert"></span>
                            </div>

                            <button type="submit" class="btn btn-primary float-right" :disabled="isSavingOptimalStock">
                                <i class="far fa-save" aria-hidden="true"></i> Save
                            </button>
                        </form>
                    </modal>
                </div>
            </div>

            <table class="w-full">
                <tbody>
                    <tr v-for="food in foods" :key="food.id" class="cursor-pointer hover:bg-gray-200" :class="isExpiredClass(food)" @click="openUpdateStockModal(food)" :title="moment(food.expired_after).format('YYYY-MM-DD')">
                        <td v-text="food.name" class="px-2 py-1"></td>
                        <td v-text="food.count" class="px-2 py-1 text-right font-mono"></td>
                        <td v-text="food.weight + 'g'" class="px-2 py-1 text-right font-mono"></td>
                    </tr>
                </tbody>
            </table>

            <create-food :food_group="food_group" v-on:food-created="addFood"></create-food>

            <modal :showing="showUpdateStockModal" @close="showUpdateStockModal = false">
                <form v-on:submit.prevent="saveCurrentStock">
                    <input type="hidden" name="id" v-model="selectedStockFood.id">

                    <div class="mb-6">
                        <label for="name">Name</label>
                        <input id="name" type="text" name="name" v-model="selectedStockFood.name" required>

                        <span class="hidden invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>

                    <div class="flex flex-wrap md:-mx-4">
                        <div class="mb-6 md:w-1/2 md:px-4">
                            <label for="count">Number of items in stock</label>
                            <input id="count" type="number" name="count" min="1" v-model="selectedStockFood.count" required>

                            <span class="hidden invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                        </div>

                        <div class="mb-6 md:w-1/2 md:px-4">
                            <label for="weight">Weight of 1 item in gram</label>
                            <input id="weight" type="number" name="weight" min="1" v-model="selectedStockFood.weight" required>

                            <span class="hidden invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="expired_after">Expires after</label>
                        <input id="expired_after" type="date" name="expired_after" v-model="selectedStockFood.expired_after">

                        <span class="hidden invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>

                    <button type="submit" class="btn btn-primary float-right" :disabled="isSavingCurrentStock">
                        <i class="far fa-save" aria-hidden="true"></i> Save
                    </button>
                </form>
            </modal>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import moment from 'moment';

    import CreateFood from './CreateFood';
    import FormMixin from './../mixins/form';
    import MomentMixin from './../mixins/moment';

    export default {
        name: 'FoodGroup',
        components: {
            CreateFood
        },
        mixins: [
            FormMixin,
            MomentMixin,
        ],
        props: {
            food_group: {
                type: Object,
                required: true,
                validator: function (value) {
                    if (!value.id) {
                        console.error('No id for food_group!');
                        return false;
                    }

                    return true;
                }
            },
        },
        data() {
            return {
                foods: [],

                showOptimalStockModal: false,
                isSavingOptimalStock: false,
                optimalStock: 0,

                showUpdateStockModal: false,
                isSavingCurrentStock: false,
                selectedStockFood: {},
            }
        },
        mounted() {
            console.debug(`Food group ${this.food_group.id} mounted.`)

            this.foods = this.food_group.foods;

            if (this.food_group.food_plan) {
                this.optimalStock = this.food_group.food_plan.optimal_stock;
            } else {
                this.optimalStock = 0;
            }
        },
        computed: {
            iconClass () {
                return 'far fa-' + this.food_group.icon
            },
            stock () {
                let stock = 0;

                for (let i = 0; i < this.foods.length; i++) {
                    stock += this.foods[i].count * this.foods[i].weight;
                }

                return stock;
            },
            stockIconClass () {
                const CLASS_GREEN = 'far fa-check-circle text-green-500';
                const CLASS_YELLOW = 'far fa-exclamation-circle text-yellow-500';
                const CLASS_RED = 'far fa-times-circle text-red-500';

                if (this.optimalStock === 0) {
                    return CLASS_GREEN;
                }

                if (this.optimalStock < this.stock) {
                    return CLASS_GREEN;
                }

                const YELLOW_THRESHOLD = this.optimalStock / 10;

                if (this.optimalStock - YELLOW_THRESHOLD < this.stock) {
                    return CLASS_YELLOW;
                }

                return CLASS_RED;
            },
        },
        methods: {
            saveOptimalStock() {
                console.debug('Save new optimal stock', this.optimalStock);

                this.isSavingOptimalStock = true;

                let that = this;

                axios.put(this.route('foodplan.update', {
                        food_group: this.food_group
                    }), {
                        optimal_stock: this.optimalStock
                    })
                    .catch(function (err) {
                        that.isSavingOptimalStock = false;

                        if (err.response) {
                            that.handleFormErrors(err.response || []);
                            return;
                        }

                        console.error(err);
                    })
                    .then(function (response) {
                        if (response && response.data) {
                            that.food_group.food_plan = response.data;
                            that.showOptimalStockModal = false;
                        }
                    })
                    .finally(function (response) {
                        that.isSavingOptimalStock = false;
                    });
            },
            saveCurrentStock() {
                console.debug('Save current stock', this.selectedStockFood.id);

                this.isSavingCurrentStock = true;

                let that = this;

                axios.put(this.route('food.update', {
                        food: this.selectedStockFood.id
                    }), this.selectedStockFood)
                    .catch(function (err) {
                        that.isSavingCurrentStock = false;

                        if (err.response) {
                            that.handleFormErrors(err.response || []);
                            return;
                        }

                        console.error(err);
                    })
                    .then(function (response) {
                        if (response && response.data) {
                            for (let i = 0; i < that.foods.length; i++) {
                                if (that.foods[i].id === response.data.id) {
                                    that.foods[i] = response.data;
                                    break;
                                }
                            }

                            that.showUpdateStockModal = false;
                        }
                    })
                    .finally(function () {
                        that.isSavingCurrentStock = false;
                    });
            },
            openUpdateStockModal(food) {
                this.showUpdateStockModal = true;
                this.selectedStockFood = food;
            },
            addFood(food) {
                this.foods.push(food);
                console.log('pushed', food);
            },
            isExpiredClass (food) {
                const expires_at = moment(food.expired_after);
                const diff = moment().diff(expires_at, 'days');

                if (diff < -30) {
                    return '';
                } else if (diff <= 0) {
                    return 'bg-yellow-200';
                }

                return 'bg-red-200';
            },
        }
    }
</script>
