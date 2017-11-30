<template>
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
                    <h5 class="recipe-category">
                        <span v-if="!editable">{{category.title}}</span>
                        <select v-model="recipe.category.id" v-else>
                            <option v-for="category in categories" :value="category.id">{{category.title}}</option>
                        </select>
                    </h5>
                </div>
                <div class="saved-directions">
                    <h4 class="add-ingredient-headings">Directions</h4>
                    <p>
                        <span v-if="!editable">{{recipe.directions}}</span>
                        <input v-else :value="recipe.directions" v-model="recipe.directions">
                    </p>
                </div>
            </div>
            <div class="recipe-buttons">
                <span v-if="!editable" @click="editable=true" class="modify-button">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512.009 512.009" style="enable-background:new 0 0 512.009 512.009;" xml:space="preserve" width="25px" height="25px">
<g>
	<g>
		<path d="M496.393,61.679l-46.336-46.315c-20.096-20.117-55.211-20.16-75.413,0L45.79,344.218c-1.301,1.28-2.219,2.859-2.709,4.608    L0.414,498.159c-1.067,3.733-0.043,7.744,2.709,10.475c2.027,2.027,4.757,3.115,7.552,3.115c0.981,0,1.963-0.128,2.944-0.405    l149.333-42.667c1.728-0.491,3.328-1.429,4.608-2.709l328.832-328.832c10.069-10.091,15.616-23.488,15.616-37.717    C512.009,85.167,506.462,71.77,496.393,61.679z M481.31,122.031L154.42,448.922L26.185,485.551l36.651-128.213L389.726,30.447    c12.096-12.096,33.195-12.075,45.248,0l46.336,46.315C493.79,89.242,493.79,109.551,481.31,122.031z" fill="#ff4b2e"/>
	</g>
</g>
<g>
	<g>
		<path d="M496.393,61.679l-46.336-46.315c-20.096-20.117-55.211-20.16-75.413,0L45.812,344.218c-4.16,4.16-4.16,10.923,0,15.083    c4.16,4.16,10.923,4.16,15.083,0L389.726,30.447c12.096-12.096,33.195-12.075,45.248,0l46.336,46.315    c12.48,12.48,12.48,32.789,0,45.269L152.457,450.885c-4.16,4.16-4.16,10.923,0,15.083c2.091,2.069,4.821,3.115,7.552,3.115    s5.461-1.045,7.552-3.115l328.832-328.853C517.193,116.314,517.193,82.479,496.393,61.679z" fill="#ff4b2e"/>
	</g>
</g>
<g>
	<g>
		<path d="M167.54,450.885L60.873,344.218c-4.16-4.16-10.923-4.16-15.083,0c-4.16,4.16-4.16,10.923,0,15.083l106.667,106.667    c2.091,2.069,4.821,3.115,7.552,3.115s5.461-1.045,7.531-3.115C171.7,461.807,171.7,455.045,167.54,450.885z" fill="#ff4b2e"/>
	</g>
</g>
<g>
	<g>
		<path d="M444.873,66.885c-4.16-4.16-10.923-4.16-15.083,0L131.124,365.551c-4.16,4.16-4.16,10.923,0,15.083    c2.091,2.069,4.821,3.115,7.552,3.115s5.461-1.045,7.531-3.115L444.873,81.967C449.033,77.807,449.033,71.044,444.873,66.885z" fill="#ff4b2e"/>
	</g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
</svg>
                </span>
                <span @click="deleteRecipe" class="modify-button">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 59 59" style="enable-background:new 0 0 59 59;" xml:space="preserve" width="25px" height="25px">
<g>
	<path d="M29.5,51c0.552,0,1-0.447,1-1V17c0-0.553-0.448-1-1-1s-1,0.447-1,1v33C28.5,50.553,28.948,51,29.5,51z" fill="#ff4b2e"/>
	<path d="M19.5,51c0.552,0,1-0.447,1-1V17c0-0.553-0.448-1-1-1s-1,0.447-1,1v33C18.5,50.553,18.948,51,19.5,51z" fill="#ff4b2e"/>
	<path d="M39.5,51c0.552,0,1-0.447,1-1V17c0-0.553-0.448-1-1-1s-1,0.447-1,1v33C38.5,50.553,38.948,51,39.5,51z" fill="#ff4b2e"/>
	<path d="M52.5,6H38.456c-0.11-1.25-0.495-3.358-1.813-4.711C35.809,0.434,34.751,0,33.499,0H23.5c-1.252,0-2.31,0.434-3.144,1.289   C19.038,2.642,18.653,4.75,18.543,6H6.5c-0.552,0-1,0.447-1,1s0.448,1,1,1h2.041l1.915,46.021C10.493,55.743,11.565,59,15.364,59   h28.272c3.799,0,4.871-3.257,4.907-4.958L50.459,8H52.5c0.552,0,1-0.447,1-1S53.052,6,52.5,6z M21.792,2.681   C22.24,2.223,22.799,2,23.5,2h9.999c0.701,0,1.26,0.223,1.708,0.681c0.805,0.823,1.128,2.271,1.24,3.319H20.553   C20.665,4.952,20.988,3.504,21.792,2.681z M46.544,53.979C46.538,54.288,46.4,57,43.636,57H15.364   c-2.734,0-2.898-2.717-2.909-3.042L10.542,8h37.915L46.544,53.979z" fill="#ff4b2e"/>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
</svg>
                </span>

                <button v-if="editable" @click="updateRecipe">Save</button>
                <button v-if="editable" @click="editable=false">Cancel</button>
            </div>

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
