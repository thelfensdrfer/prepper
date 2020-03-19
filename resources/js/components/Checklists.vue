<template>
    <div class="flex flex-wrap -mx-4">
        <checklist
            v-for="checklist in checklists"
            :key="checklist.id"
            :checklist="checklist">
        </checklist>
    </div>
</template>

<script>
    export default {
        name: 'Checklists',
        props: {
            checklists: {
                type: Array,
                required: true
            }
        },
        mounted() {
            console.debug('Checklists mounted.');
        }
    }
</script>
