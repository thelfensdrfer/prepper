<template>
    <div class="w-full lg:w-1/2 xl:w-1/3 2xl:w-1/4 p-4">
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
                                <input id="optimal_stock" type="number" name="optimal_stock" v-model.number="optimalStock">

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
                    <tr v-for="food in food" :key="food.id" class="cursor-pointer hover:bg-gray-200" :class="isExpiredClass(food)" @click="openUpdateStockModal(food)" :title="'Expires: ' + moment(food.expired_after).format('YYYY-MM-DD')">
                        <td v-text="food.name" class="px-2 py-1"></td>
                        <td v-text="food.count" class="px-2 py-1 text-right font-mono"></td>
                        <td v-text="food.weight + 'g'" class="px-2 py-1 text-right font-mono"></td>
                    </tr>
                </tbody>
            </table>

            <create-food :food_group="food_group" v-on:food-created="addFood"></create-food>

            <modal :showing="showUpdateFoodModal" @close="showUpdateFoodModal = false">
                <form v-on:submit.prevent="updateFood">
                    <input type="hidden" name="id" v-model="selectedFood.id">

                    <div class="mb-6">
                        <label for="name">Name</label>
                        <input id="name" type="text" name="name" v-model.trim="selectedFood.name" required>

                        <span class="hidden invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>

                    <div class="flex flex-wrap md:-mx-4">
                        <div class="mb-6 w-full md:w-1/2 md:px-4">
                            <label for="count">Number of items in stock</label>
                            <input id="count" type="number" name="count" min="1" v-model.number="selectedFood.count" required>

                            <span class="hidden invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                        </div>

                        <div class="mb-6 w-full md:w-1/2 md:px-4">
                            <label for="weight">Weight of 1 item in gram</label>
                            <input id="weight" type="number" name="weight" min="1" v-model.number="selectedFood.weight" required>

                            <span class="hidden invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="expired_after">Expires after</label>
                        <v-date-picker v-model="selectedFoodExpiredAfter" :popover="{ placement: 'top', visibility: 'click' }" :id="'expired_after'" :name="'expired_after'" :masks="{ input: ['YYYY-MM-DD']}" mode="single"></v-date-picker>

                        <span class="hidden invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>

                    <button type="button" class="text-red-500" @click="deleteFood(selectedFood)" :disabled="isRemovingFood">
                        Remove
                    </button>

                    <button type="submit" class="btn btn-primary float-right" :disabled="isUpdatingFood">
                        <i class="far fa-save" aria-hidden="true"></i> Save
                    </button>
                </form>
            </modal>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import * as moment from 'moment';

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
                food: [],

                showOptimalStockModal: false,
                isSavingOptimalStock: false,
                optimalStock: 0,

                showUpdateFoodModal: false,
                isUpdatingFood: false,
                isRemovingFood: false,
                selectedFood: {},
            }
        },
        mounted() {
            console.debug(`Food group ${this.food_group.id} mounted.`)

            this.food = this.food_group.food;

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

                for (let i = 0; i < this.food.length; i++) {
                    stock += this.food[i].count * this.food[i].weight;
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
            selectedFoodExpiredAfter: {
                get () {
                    return moment(this.selectedFood.expired_after).toDate();
                },
                set (val) {
                    if (val && moment(val).isValid()) {
                        this.selectedFood.expired_after = moment(val).format('YYYY-MM-DD');
                    }
                }
            }
        },
        methods: {
            saveOptimalStock () {
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
                    .finally(function () {
                        that.isSavingOptimalStock = false;
                    });
            },
            updateFood () {
                console.debug(`Update food ${this.selectedFood.id}`);

                this.isUpdatingFood = true;

                let that = this;

                axios.put(this.route('food.update', {
                        food: this.selectedFood.id
                    }), this.selectedFood)
                    .catch(function (err) {
                        that.isUpdatingFood = false;

                        if (err.response) {
                            that.handleFormErrors(err.response || []);
                            return;
                        }

                        console.error(err);
                    })
                    .then(function (response) {
                        if (response && response.data) {
                            for (let i = 0; i < that.food.length; i++) {
                                if (that.food[i].id === response.data.id) {
                                    that.food[i] = response.data;
                                    break;
                                }
                            }

                            that.showUpdateFoodModal = false;
                        }
                    })
                    .finally(function () {
                        that.isUpdatingFood = false;
                    });
            },
            openUpdateStockModal (food) {
                this.showUpdateFoodModal = true;
                this.selectedFood = food;
            },
            addFood (food) {
                this.food.push(food);
            },
            deleteFood () {
                console.debug(`Removing food ${this.selectedFood.id}`)

                let that = this;

                axios.delete(this.route('food.delete', {
                        food: this.selectedFood
                    }))
                    .catch(function (err) {
                        that.isRemovingFood = false;

                        if (err.response) {
                            that.handleFormErrors(err.response || []);
                            return;
                        }

                        console.error(err);
                    })
                    .then(function (response) {
                        if (response && response.status === 200) {
                            for (let i = 0; i < that.food.length; i++) {
                                if (that.food[i].id === that.selectedFood.id) {
                                    that.food.splice(i, 1);
                                    break;
                                }
                            }
                        }

                        that.showUpdateFoodModal = false;
                    })
                    .finally(function () {
                        that.isRemovingFood = false;
                    });
            },
            isExpiredClass (food) {
                const expires_at = moment(food.expired_after);
                const diff = moment().diff(expires_at, 'days');

                if (diff < -30) {
                    return '';
                } else if (diff <= 0) {
                    return 'bg-yellow-100 text-yellow-900';
                }

                return 'bg-red-100 text-red-900';
            },
        }
    }
</script>
