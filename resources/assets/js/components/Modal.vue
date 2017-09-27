<template>
    <div class="modal-mask"  @click="close" transition="modal">
        <div class="modal-container" @click.stop>
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        methods : {
            close(){
                this.$emit('close');
            }
        }
    }
</script>

<style>
    * {
        box-sizing: border-box;
    }

    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(79, 79, 79, .2);
        transition: opacity .3s ease;
    }

    .modal-container {
        width: 300px;
        margin: 150px auto 0;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 8px rgba(53, 53, 53, .15);
        transition: all .3s ease;
        position: relative;
        display: flex;
        flex-direction: column;
    }
</style>
