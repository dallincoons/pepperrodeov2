<template>
    <div>
        <button @click="back">Back</button>
        <ul>
            <li v-for="recipe in recipes">{{recipe.title}}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: [
            'recipes'
        ],

        methods : {
            back() {
                this.$emit('close');
            }
        }
    }
</script>
