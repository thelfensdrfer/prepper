<template>
    <div class="w-full md:w-1/2 lg:w-1/3 xl:w-1/4 p-4">
        <div class="shadow p-4">
            <div class="flex mb-4">
                <h3 class="flex-grow mb-0">
                    <i class="text-xl pl-1" :class="iconClass" aria-hidden="true"></i>

                    {{ foodgroup.name }}
                </h3>

                <div class="flex-shrink leading-8">
                    <a class="cursor-pointer" @click="adjustOptimalStockShowing = true">
                        <i :class="stockIconClass" aria-hidden="true"></i> {{ stock }} / {{ optimalStock }}
                    </a>

                    <modal :showing="adjustOptimalStockShowing" @close="adjustOptimalStockShowing = false">
                        <form v-on:submit.prevent="saveOptimalStock">
                            <div class="mb-6 flex flex-wrap">
                                <label for="optimal_stock">Adjust optimal stock</label>
                                <input id="optimal_stock" type="number" name="optimal_stock" v-model="optimalStock">

                                <span class="hidden invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
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
                    <tr v-for="food in foodgroup.foods" v-bind:key="food.id" class="hover:bg-gray-300">
                        <td v-text="food.name" class="p-1"></td>
                        <td v-text="food.count" class="p-1 text-right font-mono"></td>
                        <td v-text="food.weight + 'g'" class="p-1 text-right font-mono"></td>
                    </tr>
                </tbody>
            </table>
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
                adjustOptimalStockShowing: false,
                isSavingOptimalStock: false,
                optimalStock: 0,
            }
        },
        mounted() {
            console.log('Component mounted.')

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

                        let errorElement =  that.$el.querySelector('.invalid-feedback');
                        errorElement.classList.remove('hidden');
                        errorElement.querySelector('strong').innerText = 'There was an error while trying to save the data! Please try again later.';
                    })
                    .then(function (response) {
                        if (response && response.data) {
                            let errorElement =  that.$el.querySelector('.invalid-feedback');
                            errorElement.classList.add('hidden');
                            errorElement.querySelector('strong').innerText = '';

                            that.foodgroup.food_plan = response.data;
                            that.adjustOptimalStockShowing = false;
                        }
                    })
                    .finally(function (data) {
                        that.isSavingOptimalStock = false;
                    });
            }
        }
    }
</script>
