<template>
    <div class="w-full lg:w-1/2 xl:w-1/3 2xl:w-1/4 p-4">
        <div class="shadow p-4">
            <div class="flex mb-4">
                <h3 class="flex-grow mb-0">
                    <i class="text-xl pl-1" :class="iconClass" aria-hidden="true"></i>&nbsp;{{ checklist.name }}
                </h3>

                <div class="flex-shrink">
                    <div class="h-full px-2 py-1">
                        <i :class="checklistIconClass" aria-hidden="true"></i> {{ countAvailableItems }} / {{ items.length }}
                    </div>
                </div>
            </div>

            <table class="w-full">
                <tbody>
                    <tr v-for="item in items" :key="item.id" class="cursor-pointer hover:bg-gray-200" @click="openUpdateItemModal(item)">
                        <td>
                            <i class="far fa-fw" :class="{ 'fa-check-circle text-green-500': item.count > 0, 'fa-times text-red-500': item.count === 0 }" aria-hidden="true"></i>
                        </td>
                        <td v-text="item.name" class="px-2 py-1"></td>
                        <td v-text="item.count" class="px-2 py-1 text-right font-mono"></td>
                    </tr>
                </tbody>
            </table>

            <create-item :checklist="checklist" v-on:item-created="addItem"></create-item>

            <modal :showing="showUpdateItem" @close="showUpdateItem = false">
                <form v-on:submit.prevent="updateItem">
                    <input type="hidden" name="id" v-model="selectedItem.id">

                    <div class="flex flex-wrap md:-mx-4">
                        <div class="mb-6 w-full md:w-1/2 md:px-4">
                            <label for="name">Name</label>
                            <input id="name" type="text" name="name" v-model.trim="selectedItem.name" required>

                            <span class="hidden invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                        </div>

                        <div class="mb-6 w-full md:w-1/2 md:px-4">
                            <label for="count">Number of items</label>
                            <input id="count" type="number" name="count" min="0" v-model.number="selectedItem.count" required>

                            <span class="hidden invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary float-right" :disabled="isSavingItem">
                        <i class="far fa-save" aria-hidden="true"></i> Save
                    </button>
                </form>
            </modal>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    import CreateItem from './CreateItem';
    import FormMixin from './../mixins/form';

    export default {
        name: 'Checklist',
        components: {
            CreateItem
        },
        mixins: [
            FormMixin,
        ],
        props: {
            checklist: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                items: [],

                showUpdateItem: false,
                isSavingItem: false,
                selectedItem: {},
            }
        },
        mounted() {
            console.debug(`Checklist ${this.checklist.id} mounted.`)

            this.items = this.checklist.items;
        },
        computed: {
            iconClass () {
                return 'far fa-' + this.checklist.icon
            },
            countAvailableItems () {
                return this.items.filter(function (item) {
                    return item.count > 0;
                }).length;
            },
            checklistIconClass () {
                const CLASS_GREEN = 'far fa-check-circle text-green-500';
                const CLASS_RED = 'far fa-times-circle text-red-500';

                if (this.items.length === this.countAvailableItems) {
                    return CLASS_GREEN;
                }

                return CLASS_RED;
            },
        },
        methods: {
            updateItem() {
                console.debug('Save selected item', this.selectedItem.id);

                this.isSavingItem = true;

                let that = this;

                axios.put(this.route('checklist.item.update', {
                        item: this.selectedItem.id
                    }), this.selectedItem)
                    .catch(function (err) {
                        that.isSavingItem = false;

                        if (err.response) {
                            that.handleFormErrors(err.response || []);
                            return;
                        }

                        console.error(err);
                    })
                    .then(function (response) {
                        if (response && response.data) {
                            for (let i = 0; i < that.items.length; i++) {
                                if (that.items[i].id === response.data.id) {
                                    that.items[i] = response.data;
                                    break;
                                }
                            }

                            that.showUpdateItem = false;
                        }
                    })
                    .finally(function () {
                        that.isSavingItem = false;
                    });
            },
            openUpdateItemModal(item) {
                this.showUpdateItem = true;
                this.selectedItem = item;
            },
            addItem(item) {
                this.items.push(item);
            }
        }
    }
</script>
