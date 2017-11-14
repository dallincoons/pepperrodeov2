<template>
    <div class="container">
        <div class="recipe-wrapper">
            <div class="side-section">
                <h4 class="add-ingredient-headings">Ingredients</h4>
                <div class="all-ingredients">
                    <ul class="saved-list-of-ingredients">
                        <li v-for="ingredient in recipe.ingredients" class="ingredient-items">
                            <span v-if="nonEditable">{{ingredient.description}}</span>
                            <input :value="ingredient.description" v-else v-model="ingredient.description">
                        </li>
                    </ul>
                </div>

                <div class="need-to-buys-section">
                    <h4 class="add-ingredient-headings">Need to Buy</h4>
                    <ul class="saved-buy-item-list">
                        <li v-for="listable_ingredient in recipe.listable_ingredients" class="buy-items">
                            <span v-if="nonEditable">{{listable_ingredient.description}}</span>
                            <input :value="listable_ingredient.description" v-else v-model="listable_ingredient.description">
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-section">
                <div class="recipe-heading">
                    <h3 class="recipe-title">
                        <span v-if="nonEditable">{{recipe.title}}</span>
                        <input :value="recipe.title" v-else v-model="recipe.title">
                    </h3>
                    <h4 class="recipe-category">
                        <span v-if="nonEditable">{{category.title}}</span>
                        <select v-model="recipe.category.id" v-else>
                            <option v-for="category in categories" :value="category.id">{{category.title}}</option>
                        </select>
                    </h4>
                </div>
                <div class="saved-directions">
                    <h4 class="add-ingredient-headings">Directions</h4>
                    <p><span v-if="nonEditable">{{recipe.directions}}</span><input :value="recipe.directions" v-else v-model="recipe.directions"></p>
                </div>
            </div>
    </div>
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
                    this.nonEditable = true;
                });
            }
        }
    }

</script>
