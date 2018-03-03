<template>
    <div class="container">
        <div class="main">
            <div class="grid-heading">
                <div class="grid-row-1">
                    <div class="grid-item"><span class="grid-label">Title</span><input type="text" required v-model="recipeTitle"></div>
                    <div class="grid-item"><span class="grid-label">Category</span>
                        <select v-model="selectedCategory">
                            <option v-for="category in  categories" :value="category.id">{{category.title}}</option>
                        </select>
                    </div>
                </div>
                <div class="grid-row-2">
                    <div class="grid-item"><span class="grid-label">Prep Time</span><input type="text"></div>
                    <div class="grid-item"><span class="grid-label">Total Time</span><input type="text"></div>
                    <div class="grid-item"><span class="grid-label">Serves</span><input type="text"></div>
                </div>
            </div>
            <div class="main-content">
                <div class="toggleSection">
                    <h4 @click="toggleIngredients = true">Ingredients</h4>
                    <h4 @click="toggleIngredients = false">Directions</h4>
                </div>
                <div v-show="toggleIngredients">
                    <input class="ingredients-input" v-model="ingredientDescription"><span @click="addIngredient">+</span>
                    <ul>
                        <li v-for="ingredient in ingredients">{{ingredient.description}}</li>
                    </ul>
                    <h5>Need to Buy</h5>
                    <ul>
                        <li v-for="needToBuy in needToBuys">{{needToBuy.description}}</li>
                    </ul>
                </div>

                <div v-show="!toggleIngredients">
                    <textarea v-model="directions"></textarea>
                </div>
                <div>
                    <button @click="saveRecipe">Save</button>
                    <button>Cancel</button>
                </div>
            </div>

        </div>
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
                categories       : [],
                ingredientDescription : '',
                ingredients           : [],
                needToBuys            : [],
                directions            : '',
                departments           : '',
                toggleIngredients     : true
            }
        },
        mounted() {
            Categories.all().then((response) => {
                this.categories = response.data;
            });
            axios.get('/api/v1/departments').then((response) => {
                this.departments = response.data;
            });
        },
        methods    : {
            saveRecipe() {
                Recipes.save({
                    title                : this.recipeTitle,
                    category_id             : this.selectedCategory,
                    ingredients          : this.ingredients,
                    listable_ingredients : this.needToBuys,
                    directions           : this.directions
                }).then((response) => {
                    this.$router.push({path : `/recipe/${response.data.id}`});
                });
            },

            addIngredient() {
                if (this.ingredientDescription === '') {
                    return;
                }

                let newIngredient = {description : this.ingredientDescription};
                this.ingredients.push(newIngredient);
                this.needToBuys.push(Object.assign({}, newIngredient));
                this.ingredientDescription = '';
            },

            deleteIngredient(index) {
                this.ingredients.splice(index, 1);
            },

            deleteNeedToBuy(index) {
                this.needToBuys.splice(index, 1);
            },
        }
    }

</script>
