<template>
    <div class="recipe-list-container">
        <div class="recipe-list-heading">
            <h4 class="recipe-list-header recipes-on">Recipes On {{list.title}}</h4>
        </div>

        <div class="recipes-list-wrapper">
            <div v-for="(recipeGroup, categoryName) in groupedRecipes" class="category-container-add-list">
                <h3 class="small_dept_heading">{{categoryName}}</h3>
                <ul class="recipes-list-items">
                    <li class="recipe-list-item" v-for="recipe in recipeGroup">
                        <router-link :to="{name: 'recipe', params: {id : recipe.id}}">{{recipe.title}}</router-link>
                        <span @click="removeRecipeFromList(recipe.id)" class="remove-recipe-icon"><x-icon></x-icon></span>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</template>

<script>
    import Trashcan from "./assets/trashcan";
    import xIcon from "./assets/x-icon"
    export default {
        components: {Trashcan, xIcon},
        props: [
            'recipes',
            'list'
        ],

        computed : {
            orderedRecipes: function() {
                return _.sortBy(this.recipes, 'title')
            },
            groupedRecipes() {
                return _.groupBy(this.recipes, function (recipe) {
                    return recipe.category.title;
                });
            }
        },

        methods : {

            removeRecipeFromList(recipeId) {
                axios.delete('api/v1/grocerylist/' + this.list.id + '/recipe/' + recipeId).then((response) => {
                    if (response.status === 200) {
                        this.$emit('deleted');
                    }
                });
            }
        }
    }
</script>
