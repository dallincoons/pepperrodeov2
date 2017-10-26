<template>
    <div class="container">
        <div class="container-heading"><h2>My Recipes</h2></div>
        <div class="container-body">
            <ul class="list-container">
                <li class="recipe-ingredient" v-for="recipe in recipes"><router-link :to="{ name: 'recipe', params: { id: recipe.id }}">{{recipe.title}}</router-link></li>
            </ul>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                recipes : []
            }
        },
        mounted() {
            axios.get('/api/v1/recipes').then((response) => {
                this.recipes = response.data;
            });

        }

    }
</script>
