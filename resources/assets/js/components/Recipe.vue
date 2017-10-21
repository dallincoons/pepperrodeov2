<template>
<div>
    <div>{{recipeTitle}}</div>
    <ul>
        <li v-for="ingredient in recipeIngredients">{{ingredient.description}}</li>
    </ul>
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
