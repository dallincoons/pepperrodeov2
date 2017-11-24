<template>
    <div class="container">
        <div class="container-heading"><h2>My Recipes</h2></div>
        <div class="container-body">
            <div v-for="(recipeGroup, categoryName) in groupedRecipes" class="category-container">
                <h3 class="category-heading">{{categoryName}}</h3>
                <ul class="list-container">
                    <li class="recipe-ingredient" v-for="recipe in recipeGroup">
                        <router-link :to="{ name: 'recipe', params: { id: recipe.id }}">{{recipe.title}}</router-link>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</template>

<script>
    import Recipes from './resources/Recipes.js';
    import _ from 'lodash';

    export default {
        data() {
            return {
                recipes : []
            }
        },

        computed : {
            groupedRecipes() {
                return _.groupBy(this.recipes, 'category.title');
            }
        },

        mounted() {
            Recipes.all().then((response) => {
                this.recipes = response.data;
            });
        }

    }
</script>
