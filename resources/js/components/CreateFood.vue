<template>
    <div class="clearfix mt-4">
        <a @click="showModal = true" class="cursor-pointer float-right btn btn-default">
            <i class="far fa-plus" aria-hidden="true"></i> Add
        </a>

        <modal :showing="showModal" @close="showModal = false">
            <form v-on:submit.prevent="save">
                <div class="mb-6">
                    <label for="name">Name</label>
                    <input id="name" type="text" name="name" v-model.trim="newFood.name" required>

                    <span class="hidden invalid-feedback" role="alert">
                        <strong></strong>
                    </span>
                </div>

                <div class="flex flex-wrap md:-mx-4">
                    <div class="mb-6 w-full md:w-1/2 md:px-4">
                        <label for="count">Number of items</label>
                        <input id="count" type="number" name="count" min="1" v-model.number="newFood.count">

                        <span class="hidden invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>

                    <div class="mb-6 w-full md:w-1/2 md:px-4">
                        <label for="weight">Weight of 1 item in gram</label>
                        <input id="weight" type="number" name="weight" min="1" v-model.number="newFood.weight">

                        <span class="hidden invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="expired_after">Expires after</label>
                    <input id="expired_after" type="date" name="expired_after" v-model="newFood.expired_after">

                    <span class="hidden invalid-feedback" role="alert">
                        <strong></strong>
                    </span>
                </div>

                <button type="submit" class="btn btn-primary float-right" :disabled="isSaving">
                    <i class="far fa-save" aria-hidden="true"></i> Save
                </button>
            </form>
        </modal>
    </div>
</template>

<style scoped>

</style>

<script>
    import FormMixin from './../mixins/form';

    export default {
        name: 'CreateFood',
        mixins: [
            FormMixin,
        ],
        props: {
            food_group: {
                type: Object,
                required: true,
            }
        },
        data () {
            return {
                showModal: false,
                isSaving: false,
                newFood: {
                    name: null,
                    count: 1,
                    weight: 1000,
                    expired_after: null,
                }
            }
        },
        methods: {
            save() {
                console.debug('Save new food', this.newFood);

                this.isSaving = true;

                let that = this;

                axios.post(this.route('food.store', {
                        food_group: this.food_group.id
                    }), this.newFood)
                    .catch(function (err) {
                        that.isSaving = false;

                        if (err.response) {
                            that.handleFormErrors(err.response || []);
                            return;
                        }

                        console.error(err);
                    })
                    .then(function (response) {
                        if (response && response.data) {
                            that.showModal = false;
                            that.$emit('food-created', response.data);
                        }
                    })
                    .finally(function (response) {
                        that.isSaving = false;
                    });
            },
        }
    }
</script>
