<template>
    <div class="recipe-list-container">
        <div class="recipe-list-heading">
            <h4 class="recipe-list-header">Recipes On {{list.title}}</h4>
            <!--<button @click="back">Back</button>-->
        </div>

        <div class="recipes-list-wrapper">
            <ul class="recipes-list-items">
                <li class="recipe-list-item" v-for="recipe in orderedRecipes">
                    <router-link :to="{name: 'recipe', params: {id : recipe.id}}">{{recipe.title}}</router-link>
                    <span @click="removeRecipeFromList(recipe.id)" class="remove-recipe-icon"><x-icon></x-icon></span>
                </li>
            </ul>
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
            }
        },

        methods : {
            back() {
                this.$emit('close');
            },

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
