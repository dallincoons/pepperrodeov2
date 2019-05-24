<template>
    <div class="recipe-list-container">
        <div class="recipe-list-heading">
            <h2 class="container-heading">Recipes Added to {{list}}</h2>
            <button @click="back">Back</button>
        </div>

        <div class="recipes-list-wrapper">
            <ul class="recipes-list-items">
                <li class="recipe-list-item" v-for="recipe in orderedRecipes"><router-link :to="{name: 'recipe', params: {id : recipe.id}}">{{recipe.title}}</router-link></li>
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

        data() {
            return {
                orderedRecipes: []
            }
        },

        created() {
            this.orderedRecipes = _.sortBy(this.recipes, 'title');
        },

        methods : {
            back() {
                this.$emit('close');
            }
        }
    }
</script>
