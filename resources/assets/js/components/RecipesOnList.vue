<template>
    <div>
        <button @click="back">Back</button>
        <h1>hi</h1>
    </div>
</template>

<script>
    export default {
        methods : {
            back() {
                this.$emit('close');
            }
        }
    }
</script>
