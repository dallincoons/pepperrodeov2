<template>
        <div :class="modalClass" @click.stop>
            <div class="fs-wrapper">
                <div @click="close" class="fs-close-modal"><slot name="close"><span>x</span></slot></div>
                <slot></slot>
            </div>

        </div>
</template>

<script>
    export default {

        props: {
            modalClass : {
                type: String,
                default: 'ol-modal-container'
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

