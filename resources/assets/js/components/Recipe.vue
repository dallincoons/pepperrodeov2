<template>
    <div class="container">
        <div class="heading-section recipe-heading">
            <h2>
                <span v-if="nonEditable">{{recipe.title}}</span>
                <input :value="recipe.title" v-else v-model="recipe.title">
            </h2>
            <h4>
                <span v-if="nonEditable">{{category.title}}</span>
                <select v-model="recipe.category.id" v-else>
                    <option v-for="category in categories" :value="category.id">{{category.title}}</option>
                </select>
            </h4>
        </div>
        <div class="recipe-container">
            <div class="recipe-items-section">
                <div class="ingredients-section">
                    <h4 class="add-ingredient-headings">Ingredients</h4>
                    <div class="all-ingredients">
                        <ul class="saved-list-of-ingredients">
                            <li v-for="ingredient in recipe.ingredients" class="ingredient-items">
                                <span v-if="nonEditable">{{ingredient.description}}</span>
                                <input :value="ingredient.description" v-else>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="need-to-buys-section">
                    <h4 class="add-ingredient-headings">Need to Buy</h4>
                    <ul class="saved-buy-item-list">
                        <li v-for="ingredient in recipe.listable_ingredients" class="buy-items">
                            <span v-if="nonEditable">{{ingredient.description}}</span>
                            <input :value="ingredient.description" v-else>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="saved-directions">
                <h4 class="add-ingredient-headings">Directions</h4>
                <p><span v-if="nonEditable">{{recipe.directions}}</span><input :value="recipe.directions" v-else
                                                                               v-model="recipe.directions"></p>
            </div>
        </div>
        <button @click="deleteRecipe">Delete</button>
        <button v-if="nonEditable" @click="nonEditable=false">Edit Recipe</button>
        <button v-else @click="updateRecipe">Save</button>
    </div>

</template>
<script>

    import Recipe from './resources/Recipes.js';
    import Categories from './resources/Categories.js';

    export default {
        data() {
            return {
                recipe      : {},
                category    : {},
                nonEditable : true,
                categories  : ['sdfsdfsdf']
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
                    category_id : this.recipe.category.id
                }).then((response) => {
                    this.getRecipe();
                    this.nonEditable = true;
                });
            }
        }
    }

</script>
