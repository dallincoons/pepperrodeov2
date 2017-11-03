<template>
<div class="container">
    <div class="heading-section recipe-heading">
        <h2>{{recipe.title}}</h2>
        <h4>{{category.title}}</h4>
    </div>
    <div class="recipe-container">
        <div class="recipe-items-section">
            <div class="ingredients-section">
                <h4 class="add-ingredient-headings">Ingredients</h4>
                <div class="all-ingredients">
                    <ul class="saved-list-of-ingredients">
                        <li v-for="ingredient in recipe.ingredients" class="ingredient-items">{{ingredient.description}}</li>
                    </ul>
                </div>
            </div>

                <div class="need-to-buys-section">
                    <h4 class="add-ingredient-headings">Need to Buy</h4>
                    <ul class="saved-buy-item-list">
                        <li v-for="ingredient in recipe.ingredients" class="buy-items">{{ingredient.description}}</li>
                    </ul>
                </div>
            </div>
            <div class="saved-directions">
                <h4 class="add-ingredient-headings">Directions</h4>
                <p>{{recipe.directions}}</p>
            </div>
        </div>

    </div>

</template>
<script>

    export default {
        data() {
            return {
                recipe : {},
                category : {}
            }
        },
        mounted() {
            this.recipeId = this.$route.params.id;
            this.getRecipe();
        },
        methods : {
            getRecipe() {
                axios.get('/api/v1/recipes/' + this.recipeId).then((response) => {
                    this.recipe = response.data;
                    this.category = this.recipe.category;
                });
            }
        }
    }

</script>
