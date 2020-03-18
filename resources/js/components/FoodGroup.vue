<template>
    <div class="w-full md:w-1/2 lg:w-1/3 xl:w-1/4 p-4">
        <div class="shadow p-4">
            <div class="flex mb-4">
                <h3 class="flex-grow mb-0">
                    <i class="text-xl pl-1" :class="iconClass" aria-hidden="true"></i>

                    {{ foodgroup.name }}
                </h3>

                <div class="flex-shrink">
                    <a class="cursor-pointer block h-full px-2 py-1 hover:text-blue-500" @click="showOptimalStockModal = true">
                        <i :class="stockIconClass" aria-hidden="true"></i> {{ stock }} / {{ optimalStock }}
                    </a>

                    <modal :showing="showOptimalStockModal" @close="showOptimalStockModal = false">
                        <form v-on:submit.prevent="saveOptimalStock">
                            <div class="mb-6 flex flex-wrap">
                                <label for="optimal_stock">Adjust optimal stock</label>
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
                    <tr v-for="food in foodgroup.foods" v-bind:key="food.id" class="cursor-pointer hover:bg-gray-200" @click="openUpdateStockModal(food)">
                        <td v-text="food.name" class="px-2 py-1"></td>
                        <td v-text="food.count" class="px-2 py-1 text-right font-mono"></td>
                        <td v-text="food.weight + 'g'" class="px-2 py-1 text-right font-mono"></td>
                    </tr>
                </tbody>
            </table>

            <modal :showing="showUpdateStockModal" @close="showUpdateStockModal = false">
                <form v-on:submit.prevent="saveCurrentStock">
                    <input type="hidden" name="id" v-model="selectedStockFood.id">

                    <div class="mb-6 flex flex-wrap">
                        <label for="count">Number of items in stock</label>
                        <input id="count" type="number" name="count" min="1" v-model="selectedStockFood.count">

                        <span class="hidden invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>

                    <div class="mb-6 flex flex-wrap">
                        <label for="weight">Weight of 1 item in gram</label>
                        <input id="weight" type="number" name="weight" min="1" v-model="selectedStockFood.weight">

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

    export default {
        props: {
            foodgroup: {
                type: Object
            }
        },
        data() {
            return {
                showOptimalStockModal: false,
                isSavingOptimalStock: false,
                optimalStock: 0,

                showUpdateStockModal: false,
                isSavingCurrentStock: false,
                selectedStockFood: {},
            }
        },
        mounted() {
            console.debug(`Food group ${this.foodgroup.id} mounted.`)

            if (this.foodgroup.food_plan) {
                this.optimalStock = this.foodgroup.food_plan.optimal_stock;
            } else {
                this.optimalStock = 0;
            }
        },
        computed: {
            iconClass() {
                return 'far fa-' + this.foodgroup.icon
            },
            stock() {
                let stock = 0;

                for (let i = 0; i < this.foodgroup.foods.length; i++) {
                    stock += this.foodgroup.foods[i].count * this.foodgroup.foods[i].weight;
                }

                return stock;
            },
            stockIconClass() {
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
            }
        },
        methods: {
            setInputError(inputName, message) {
                let feedbackElement =  this.$el
                    .querySelector('[name="' + inputName + '"]')
                    .parentNode
                    .querySelector('.invalid-feedback');

                if (!feedbackElement) {
                    console.error('Could not find invalid-feedback element next to ' + inputName);
                    return;
                }

                feedbackElement.classList.remove('hidden');
                feedbackElement.innerText = message;
            },
            handleFormErrors(response) {
                if (response.status === 422 && response.data && response.data.errors) {
                    for (let [inputName, errors] of Object.entries(response.data.errors)) {
                        this.setInputError(inputName, errors[0]);
                    }
                } else {
                    console.error(response);
                }
            },
            saveOptimalStock() {
                console.debug('Save new optimal stock', this.optimalStock);

                this.isSavingOptimalStock = true;

                let that = this;

                axios.put(this.route('foodplan.update', {
                        food_group: this.foodgroup
                    }), {
                        optimal_stock: this.optimalStock
                    })
                    .catch(function (err) {
                        that.isSavingOptimalStock = false;

                        that.handleFormErrors(err.response);
                    })
                    .then(function (response) {
                        if (response && response.data) {
                            that.foodgroup.food_plan = response.data;
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

                        that.handleFormErrors(err.response);
                    })
                    .then(function (response) {
                        if (response && response.data) {
                            for (let i = 0; i < that.foodgroup.foods.length; i++) {
                                if (that.foodgroup.foods[i].id === response.data.id) {
                                    that.foodgroup.foods[i] = response.data;
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
            }
        }
    }
</script>
