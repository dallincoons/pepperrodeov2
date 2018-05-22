<template>
    <div class="recipe-list-container">
        <div class="recipe-list-heading">
            <h2 class="container-heading">Recipes Added to {{list}}</h2>
            <button @click="back">Back</button>
        </div>

        <div class="recipes-list-wrapper">
            <ul class="recipes-list-items">
                <li class="recipe-list-item" v-for="recipe in recipes"><router-link :to="{name: 'recipe', params: {id : recipe.id}}">{{recipe.title}}</router-link></li>
            </ul>
        </div>

    </div>
</template>

<script>
    export default {
        props: [
            'recipes',
            'list'
        ],

        methods : {
            back() {
                this.$emit('close');
            }
        }
    }
</script>
