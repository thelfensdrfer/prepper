<template>
    <div class="flex flex-wrap -mx-4">
        <checklist
            v-for="checklist in lists"
            :key="checklist.id"
            :checklist="checklist">
        </checklist>
    </div>
</template>

<script>
    import EventBus from './../eventbus'

    export default {
        name: 'Checklists',
        props: {
            checklists: {
                type: Array,
                required: true
            }
        },
        data () {
            return {
                lists: this.checklists
            }
        },
        mounted() {
            console.debug('Checklists mounted.');

            let that = this;

            EventBus.$on('checklist-created', function (checklist) {
                that.lists.push(checklist);
            })
        }
    }
</script>
