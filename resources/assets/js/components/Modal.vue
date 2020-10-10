<template>
    <transition name="modal-fade">
    <div class="backdrop-modal"  @click="close">
            <slot></slot>
    </div>
    </transition>
</template>

<script>
    export default {

        props: {
            modalClass : {
                type: String,
                default: 'modal-container'
            }
        },

        data() {
            return {
                defaultClass: 'test2'
            }
        },

        methods : {
            close(){
                this.$emit('close');
            },
        }
    }
</script>
