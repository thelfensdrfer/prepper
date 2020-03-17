<template>
    <div class="flex flex-wrap -mx-4">
        <food-group
            v-for="food in groups"
            v-bind:key="food.id"
            v-bind:foodgroup="food">
        </food-group>
    </div>
</template>

<script>
    export default {
        props: {
            groups: {
                type: Array
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
