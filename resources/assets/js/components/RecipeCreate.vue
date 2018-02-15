<template>
    <div class="container">
        <!--<h2 class="container-heading create-heading">Add a Recipe</h2>-->
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
        <new-ingredient-form v-else :recipeTitle="recipeTitle" :recipeCat="selectedCategory"
                             @save="saveRecipe"></new-ingredient-form>
    </div>
</template>


<script>
    import NewIngredientForm from './NewIngredientForm.vue';

    import Categories from './resources/Categories.js';
    import Recipes from './resources/Recipes.js';

    export default {
        components : {
            NewIngredientForm
        },
        data() {
            return {
                recipeTitle      : '',
                titleSectionOpen : false,
                selectedCategory : '',
                categories       : []
            }
        },
        mounted() {
            Categories.all().then((response) => {
                this.categories = response.data;
            });
        },
        methods    : {
            saveRecipe(description, ingredients, needToBuys) {
                Recipes.save({
                    title                : this.recipeTitle,
                    category_id          : this.selectedCategory.id,
                    directions           : description,
                    ingredients          : ingredients,
                    listable_ingredients : needToBuys
                }).then((response) => {
                    this.$router.push({path : `/recipe/${response.data.id}`});
                });
            },
        }
    }

</script>
