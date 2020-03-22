<template>
    <modal :showing="showModal" @close="showModal = false">
        <form v-on:submit.prevent="save">
            <div class="flex flex-wrap md:-mx-4">
                <div class="mb-6 w-full md:w-1/2 md:px-4">
                    <label for="name">Name</label>
                    <input id="name" type="text" name="name" v-model.trim="updateChecklist.name" required>

                    <span class="hidden invalid-feedback" role="alert">
                        <strong></strong>
                    </span>
                </div>

                <div class="mb-6 w-full md:w-1/2 md:px-4">
                    <label for="icon">Icon <i class="" aria-hidden="true" id="preview-icon"></i></label>

                    <div class="block relative">
                        <select id="icon" name="icon" class="inline-block" v-model="updateChecklist.icon" @change="previewIcon()">
                            <option v-for="icon in icons" :value="icon.value" v-text="icon.label"></option>
                        </select>

                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <i class="far fa-chevron-down" aria-hidden="true"></i>
                        </div>
                    </div>

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
</template>

<style scoped>

</style>

<script>
    import _ from 'lodash';

    import icons from './../data/icons';
    import FormMixin from './../mixins/form';
    import EventBus from './../eventbus';

    export default {
        name: 'CreateChecklist',
        mixins: [
            FormMixin,
        ],
        props: {
            checklist: {
                type: Object,
                required: true,
            },
            showModal: {
                type: Boolean,
                required: true
            }
        },
        data () {
            return {
                isSaving: false,
                updateChecklist: {
                    name: null,
                    icon: null,
                },
                icons: []
            }
        },
        mounted () {
            this.updateChecklist.name = this.checklist.name;
            this.updateChecklist.icon = this.checklist.icon;

            this.icons = icons.sort().map(function (icon) {
                return {
                    value: icon.value,
                    label: _.startCase(icon.value),
                };
            });
        },
        methods: {
            save () {
                console.debug('Update checklist', this.updateChecklist);

                this.isSaving = true;

                let that = this;

                axios.put(this.route('checklist.update', {
                    checklist: this.checklist
                }), this.updateChecklist)
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
                            EventBus.$emit('checklist-updated', response.data);
                        }
                    })
                    .finally(function () {
                        that.isSaving = false;
                    });
            },
            previewIcon () {
                const previewIcon = this.$el.querySelector('#preview-icon');
                previewIcon.classList.remove(...previewIcon.classList);
                previewIcon.classList.add(
                    'far',
                    'fa-' + this.updateChecklist.icon,
                );
            }
        }
    }
</script>
