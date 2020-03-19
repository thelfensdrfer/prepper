<template>
    <div class="flex flex-wrap -mx-4">
        <food-group
            v-for="group in food_groups"
            :key="group.id"
            :food_group="group">
        </food-group>
    </div>
</template>

<script>
    export default {
        name: 'FoodGroups',
        props: {
            food_groups: {
                type: Array,
                required: true
            }
        },
        mounted() {
            console.debug('Food groups mounted.');
        }
    }
</script>
