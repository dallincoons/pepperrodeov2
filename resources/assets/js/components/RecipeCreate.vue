<template>
    <div class="container">
        <h2 class="container-heading">Add a Recipe</h2>
        <div class="container-create" v-if="titleSectionOpen">
            <form v-on:submit.prevent class="recipe-create-form">
                <label for="recipe-title" class="recipe-label" v-model="recipeTitle">Title</label>
                <input title="Recipe Title" class="recipe-input" id="recipe-title" v-model="recipeTitle">
                <label for="category" class="recipe-label">Category</label>
                <select id="category" class="recipe-input" v-model="selectedCategory">
                    <option v-for="category in categories" :value="category">{{category.title}}</option>
                </select>
                <button type="button" class="recipe-save save-button" @click="titleSectionOpen = !titleSectionOpen">
                    Next
                </button>
            </form>
        </div>
        <new-ingredient-form v-else :recipeTitle="recipeTitle" :recipeCat="selectedCategory"></new-ingredient-form>
    </div>
</template>


<script>
    import NewIngredientForm from './NewIngredientForm.vue';

    export default {
        components : {
            NewIngredientForm
        },
        data() {
            return {
                recipeTitle      : '',
                titleSectionOpen : true,
                selectedCategory : '',
                categories       : []
            }
        },
        mounted() {
            axios.get('/api/v1/categories').then((response) => {
                this.categories = response.data;
            });
        },
        methods    : {
            saveRecipe() {
                axios.post('/api/v1/recipes/create', {title : this.recipeTitle}).then((response) => {
                    console.log(response);
                });

            }
        }
    }

</script>
