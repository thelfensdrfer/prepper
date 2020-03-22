<template>
    <div class="flex flex-wrap -mx-4">
        <checklist
            v-for="checklist in checklists"
            :key="checklist.id"
            :list="checklist">
        </checklist>
    </div>
</template>

<script>
    import EventBus from './../eventbus'

    export default {
        name: 'Checklists',
        props: {
            lists: {
                type: Array,
                required: true
            }
        },
        data () {
            return {
                checklists: this.lists
            }
        },
        mounted() {
            console.debug('Checklists mounted.');

            let that = this;

            EventBus.$on('checklist-created', function (checklist) {
                that.checklists.push(checklist);
            })
        }
    }
</script>
