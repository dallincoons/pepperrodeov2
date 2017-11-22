<template>
    <div class="container">
        <div class="recipe-wrapper">
            <div class="side-section">
                <h4 class="add-ingredient-headings">Ingredients</h4>
                <div class="all-ingredients">
                    <button @click="addBlankIngredient" v-if="editable">Add</button>
                    <ul class="saved-list-of-ingredients">
                        <li v-for="ingredient in recipe.ingredients" class="ingredient-items">
                            <span v-if="!editable">{{ingredient.description}}</span>
                            <div v-else>
                                <input :value="ingredient.description" v-model="ingredient.description">
                                <span v-if="ingredient.id" @click="deleteIngredient(ingredient.id)">X</span>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="need-to-buys-section">
                    <h4 class="add-ingredient-headings">Need to Buy</h4>
                    <button @click="addBlankListableIngredients" v-if="editable">Add</button>
                    <ul class="saved-buy-item-list">
                        <li v-for="listable_ingredient in recipe.listable_ingredients" class="buy-items">
                            <span v-if="!editable">{{listable_ingredient.description}}</span>
                            <div v-else>
                                <input :value="listable_ingredient.description" v-model="listable_ingredient.description">
                                <span v-if="listable_ingredient.id" @click="deleteListableIngredient(listable_ingredient.id)">X</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-section">
                <div class="recipe-heading">
                    <h3 class="recipe-title">
                        <span v-if="!editable">{{recipe.title}}</span>
                        <input :value="recipe.title" v-else v-model="recipe.title">
                    </h3>
                    <h4 class="recipe-category">
                        <span v-if="!editable">{{category.title}}</span>
                        <select v-model="recipe.category.id" v-else>
                            <option v-for="category in categories" :value="category.id">{{category.title}}</option>
                        </select>
                    </h4>
                </div>
                <div class="saved-directions">
                    <h4 class="add-ingredient-headings">Directions</h4>
                    <p>
                        <span v-if="!editable">{{recipe.directions}}</span>
                        <input v-else :value="recipe.directions" v-model="recipe.directions">
                    </p>
                </div>
            </div>
        </div>

        <button @click="deleteRecipe">Delete</button>
        <button v-if="!editable" @click="editable=true">Edit Recipe</button>
        <button v-if="editable" @click="updateRecipe">Save</button>
        <button v-if="editable" @click="editable=false">Cancel</button>
    </div>


</template>
<script>

    import Recipe from './resources/Recipes.js';
    import Categories from './resources/Categories.js';
    import Ingredients from './resources/Ingredients.js';
    import ListableIngredients from './resources/ListableIngredients.js';

    export default {
        data() {
            return {
                recipe      : {},
                category    : {},
                editable : false,
                categories  : [],
            }
        },

        mounted() {
            this.recipeId = this.$route.params.id;
            this.getRecipe();

            Categories.all().then((response) => {
                this.categories = response.data;
            });
        },

        methods : {
            getRecipe() {
                Recipe.get(this.recipeId).then((response) => {
                    this.recipe   = response.data;
                    this.category = this.recipe.category;
                });
            },

            deleteRecipe() {
                Recipe.delete(this.recipeId).then(response => {
                    if (response.status === 200) {
                        this.$router.push({path : `/recipes`});
                    }
                })
            },

            updateRecipe() {
                Recipe.update(this.recipeId, {
                    title       : this.recipe.title,
                    directions  : this.recipe.directions,
                    category_id : this.recipe.category.id,
                    ingredients : this.recipe.ingredients,
                    listable_ingredients : this.recipe.listable_ingredients
                }).then((response) => {
                    this.getRecipe();
                    this.editable = false;
                });
            },

            addBlankIngredient() {
                this.recipe.ingredients.push({});
            },

            addBlankListableIngredients() {
                this.recipe.listable_ingredients.push({});
            },

            deleteIngredient(id) {
                Ingredients.delete(id).then(response => {
                    this.getRecipe();
                });
            },

            deleteListableIngredient(id) {
                ListableIngredients.delete(id).then(response => {
                    this.getRecipe();
                });
            }
        }
    }

</script>
