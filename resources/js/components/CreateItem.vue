<template>
    <div class="clearfix mt-4">
        <a @click="showModal = true" class="cursor-pointer float-right btn btn-default">
            <i class="far fa-plus" aria-hidden="true"></i> Add
        </a>

        <modal :showing="showModal" @close="showModal = false">
            <form v-on:submit.prevent="save">
                <div class="flex flex-wrap md:-mx-4">
                    <div class="mb-6 w-full md:w-1/3 md:px-4">
                        <label for="name">Name</label>
                        <input id="name" type="text" name="name" v-model.trim="newItem.name" required>

                        <span class="hidden invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>

                    <div class="mb-6 w-full md:w-1/3 md:px-4">
                        <label for="count">Number of items</label>
                        <input id="count" type="number" name="count" min="0" v-model.number="newItem.count">

                        <span class="hidden invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>

                    <div class="mb-6 w-full md:w-1/3 md:px-4">
                        <label for="target_count">Target count</label>
                        <input id="target_count" type="number" name="target_count" min="0" v-model.number="newItem.target_count">

                        <span class="hidden invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
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
        name: 'CreateItem',
        mixins: [
            FormMixin,
        ],
        props: {
            checklist: {
                type: Object,
                required: true,
            }
        },
        data () {
            return {
                showModal: false,
                isSaving: false,
                newItem: {
                    name: null,
                    count: 0,
                    target_count: 1,
                }
            }
        },
        mounted () {
            this.newItem.name = null;
            this.newItem.count = 0;
            this.newItem.target_count = 1;
        },
        methods: {
            save () {
                console.debug('Save new item', this.newItem);

                this.isSaving = true;

                let that = this;

                axios.post(this.route('checklist.item.store', {
                        checklist: this.checklist.id
                    }), this.newItem)
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
                            that.$emit('item-created', response.data);
                        }
                    })
                    .finally(function (response) {
                        that.isSaving = false;
                    });
            },
        }
    }
</script>
