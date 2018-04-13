<template>
    <div>
        <button @click="back">Back</button>
        <ul>
            <li v-for="recipe in recipes"><router-link :to="{'path': 'recipe', 'params': recipe.id}">{{recipe.title}}</router-link></li>
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
