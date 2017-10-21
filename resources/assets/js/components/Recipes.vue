<template>
    <div class="container-body">

        <ul class="list-container">
            <li v-for="recipe in recipes"><router-link :to="{ name: 'recipe', params: { id: recipe.id }}" >{{recipe.title}}</router-link></li>
        </ul>
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
