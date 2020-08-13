<template>
    <transition name="fade">
        <div
            v-if="showing"
            class="fixed inset-0 w-full h-screen flex items-center justify-center"
            style="background-color: rgba(0, 0, 0, .5)"
            @click.self="close">
            <div class="relative m-8 md:mx-0 w-full max-w-2xl bg-white shadow-lg rounded-lg p-8">
                <button
                    aria-label="close"
                    class="absolute top-0 right-0 my-2 mx-4"
                    @click.prevent="close">
                    <i class="far fa-times text-xl p-2 text-gray-500 hover:text-gray-700" aria-hidden="true"></i>
                </button>
                <slot />
            </div>
        </div>
    </transition>
</template>

<style scoped>
    .fade-enter-active,
    .fade-leave-active {
        transition: all 0.4s;
    }

    .fade-enter,
    .fade-leave-to {
        opacity: 0;
    }
</style>

<script>
    export default {
        props: {
            showing: {
                required: true,
                type: Boolean
            }
        },
        watch: {
            showing (value) {
                if (value) {
                    return document.querySelector('body').classList.add('overflow-hidden');
                }

                document.querySelector('body').classList.remove('overflow-hidden');
            }
        },
        methods: {
            close () {
                this.$emit('close');
            }
        }
    };
</script>
