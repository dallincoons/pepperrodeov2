<template>

        <div :class="[modalClass, transitionClass]" @click.stop>
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
        mounted() {
            setInterval(() => {  this.transitionClass = 'transition-fs'; }, 100);

        },

        data() {
            return {
                transitionClass : ' '
            }
        },

        methods : {
            close(){
                this.$emit('close');
            },


        }
    }
</script>

