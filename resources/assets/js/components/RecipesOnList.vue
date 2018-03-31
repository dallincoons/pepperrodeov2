<template>
    <div>
        <button @click="back">Back</button>
        <ul>
            <li v-for="recipe in recipes"><a :href="'#/recipe/' + recipe.id">{{recipe.title}}</a></li>
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
