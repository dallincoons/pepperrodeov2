<template>
    <div class="container">
        <div class="recipe-heading">
            <h2>{{recipe.title}}</h2>
            <h4>{{category.title}}</h4>
        </div>
        <div class="container-body">
            <div class="ingredients-section">
                <h4>Ingredients</h4>
                <ul>
                    <li v-for="ingredient in recipe.ingredients">{{ingredient.description}}</li>
                </ul>
            </div>
            <div class="need-to-buy-section">
                <h4>Need to Buy</h4>
                <ul>
                    <li v-for="ingredient in recipe.ingredients">{{ingredient.description}}</li>
                </ul>
            </div>
            <div class="directions-section">
                <h4>Directions</h4>
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
