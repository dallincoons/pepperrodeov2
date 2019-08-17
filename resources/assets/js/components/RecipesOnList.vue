<template>
    <div class="recipe-list-container">
        <div class="recipe-list-heading">
            <h2 class="container-heading">Recipes Added to {{list.title}}</h2>
            <button @click="back">Back</button>
        </div>

        <div class="recipes-list-wrapper">
            <ul class="recipes-list-items">
                <li class="recipe-list-item" v-for="recipe in orderedRecipes">
                    <router-link :to="{name: 'recipe', params: {id : recipe.id}}">{{recipe.title}}</router-link>
                    <span @click="removeRecipeFromList(recipe.id)"><trashcan></trashcan></span>

                </li>
            </ul>
        </div>

    </div>
</template>

<script>
    import Trashcan from "./assets/trashcan";
    export default {
        components: {Trashcan},
        props: [
            'recipes',
            'list'
        ],

        data() {
            return {
                orderedRecipes: [],
            }
        },

        created() {
            this.orderedRecipes = _.sortBy(this.recipes, 'title');
        },

        methods : {
            back() {
                this.$emit('close');
            },

            removeRecipeFromList(recipeId) {
                axios.delete('api/v1/grocerylist/' + this.list.id + '/recipe/' + recipeId).then((response) => {
                    if (response.status === 200) {
                        this.orderedRecipes = _.reject(this.orderedRecipes, {id : recipeId});
                        this.$emit('deleted');
                    }
                });
            }
        }
    }
</script>
