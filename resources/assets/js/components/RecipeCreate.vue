<template>
    <div class="container">
        <h2 class="container-heading">Add a Recipe</h2>
        <div class="container-create">
            <form v-on:submit.prevent class="recipe-create-form">
                <label for="recipe-title" class="recipe-label">Title</label>
                <input title="Recipe Title" class="recipe-input" id="recipe-title" v-model="recipeTitle">
                <label for="category" class="recipe-label">Category</label>
                <select id="category" class="recipe-input">
                    <option></option>
                </select>
                <button type="button" class="recipe-save save-button" @click="saveRecipe">Next</button>
            </form>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                recipeTitle : '',
            }
        },
        methods : {
            saveRecipe() {
                axios.post('/api/v1/recipes/create', {title : this.recipeTitle}).then((response) => {
                    console.log(response);
                });
            }
        }
    }

</script>
