<template>
<div class="container">
    <div class="recipe-heading">
        <h2>{{recipeTitle}}</h2>
        <h4>Category</h4>
    </div>
    <div class="container-body">
        <div class="ingredients-section">
            <h4>Ingredients</h4>
            <ul>
                <li v-for="ingredient in recipeIngredients">{{ingredient.description}}</li>
            </ul>
        </div>
        <div class="need-to-buy-section">
            <h4>Need to Buy</h4>
            <ul>
                <li v-for="ingredient in recipeIngredients">{{ingredient.description}}</li>
            </ul>
        </div>
        <div class="directions-section">
            <h4>Directions</h4>
            <p>First cook the stuff. Then eat the stuff.</p>
        </div>


    </div>

</div>

</template>
<script>

    export default {
        data () {
           return {
               recipeTitle : '',
               recipeIngredients : []
           }
        },
        mounted() {
            this.recipeId = this.$route.params.id;
            this.getRecipe();
        },
        methods : {
            getRecipe() {
                axios.get('/api/v1/recipes/' + this.recipeId).then((response) => {
                    console.log(response.data);
                    this.recipeTitle = response.data.title;
                    this.recipeIngredients = response.data.ingredients;
                });
            }
        }
    }

</script>
