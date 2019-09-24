<template>
    <div class="create-recipe-wrapper">
        <h2 class="create-recipe-page-title">Create Recipe</h2>
        <div class="create-recipe-section-wrapper">
            <div class="create-recipe-header" @click="createDetailsHidden = !createDetailsHidden">
                <h4>Recipe Details</h4>
                <span class="create-caret" :class="{'rotate-caret' : createDetailsHidden}"><caret></caret></span>
            </div>
            <div class="create-recipe-body" :class="{'hide-info' : createDetailsHidden}">
                <div class="create-recipe-title recipe-item">
                    <span class="create-recipe-label">Title</span>
                    <input type="text" required v-model="recipeTitle" class="create-recipe-input">
                </div>
                <div class="create-recipe-category recipe-item">
                    <span class="create-recipe-label">Category</span>
                    <ul class="create-recipe-category-list">
                        <li v-for="category in  categories" class="create-recipe-category-list-item">
                            <input type="radio" name="create-radio" :value="category.id"  v-model="selectedCategory" class="create-recipe-radio-button">
                            <label class="create-recipe-radio-label">{{category.title}}</label>
                        </li>
                    </ul>
                </div>
                <div class="create-recipe-details-numbers">
                    <div class="create-recipe-prep recipe-item">
                        <span class="create-recipe-label">Prep Time</span>
                        <input type="text" v-model="prepTime" class="create-recipe-input">
                    </div>
                    <div class="create-recipe-total recipe-item">
                        <span class="create-recipe-label">Total Time</span>
                        <input type="text" v-model="totalTime" class="create-recipe-input">
                    </div>
                    <div class="create-recipe-serves recipe-item">
                        <span class="create-recipe-label">Serves</span>
                        <input type="text" v-model="serves" class="create-recipe-input">
                    </div>
                </div>

            </div>
        </div>

        <div class="create-recipe-section-wrapper">
            <div class="create-recipe-header"  @click="createIngredientsHidden = !createIngredientsHidden">
                <h4>{{recipeTitle}} Ingredients</h4>
                <span class="create-caret" :class="{'rotate-caret' : createIngredientsHidden}"><caret></caret></span>
            </div>
            <div class="create-recipe-body" :class="{'hide-info' : createIngredientsHidden}">
                <div class="create-recipe-ingredients-ntb-wrapper">
                    <div class="create-recipe-ingredients-wrapper">
                        <label class="create-recipe-label">Add Ingredients</label>
                        <div class="create-recipe-add-ingredient-section">
                            <input class="create-ingredient-input" v-model="ingredientDescription" @keyup.enter="addIngredient" >
                            <span @click="addIngredient" class="add-ingredient-button"><add-plus class="create-recipe-add-plus"></add-plus></span>
                        </div>

                        <ul class="recipe-item">
                            <li v-for="(ingredient, index) in ingredients" class="create-ingredient-items">{{ingredient.full_description}}
                                <div @click="deleteIngredient(index)" class="x-icon"><x-icon class="x-icon-svg"></x-icon></div>
                            </li>
                        </ul>
                    </div>
                    <div class="need-to-buys-wrapper">
                        <div class="need-to-buys-section">
                            <label class="create-recipe-label create-recipe-need-to-buy-title" @click="showNeedToBuy = !showNeedToBuy">
                                Need to Buy
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="chevron" :class="{'chevron-rotate' : showNeedToBuy}" ><path d="M10.707 7.05L10 6.343 4.343 12l1.414 1.414L10 9.172l4.243 4.242L15.657 12z"/></svg>
                            </label>


                            <ul class="recipe-item create-recipe-buy-list" :class="{'buy-visible' : showNeedToBuy}">
                                <li v-for="(needToBuy, index) in needToBuys" class="create-ingredient-items">{{needToBuy.full_description}}
                                    <div @click="deleteNeedToBuy(index)" class="x-icon"><x-icon class="x-icon-svg"></x-icon></div></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="create-recipe-section-wrapper">
            <div class="create-recipe-header" @click="createDirectionsHidden = !createDirectionsHidden">
                <h4>{{recipeTitle}} Directions</h4>
                <span class="create-caret" :class="{'rotate-caret' : createDirectionsHidden}"><caret></caret></span>
            </div>
            <div class="create-recipe-body" :class="{'hide-info' : createDirectionsHidden}">
                <div class="create-recipe-title recipe-item">
                    <span class="create-recipe-label">Add Directions</span>
                    <textarea v-model="directions" class="create-recipe-input create-recipe-textarea"></textarea>
                </div>
            </div>
        </div>
        <div class="create-recipe-section-buttons">
            <button @click="saveRecipe" class="create-recipe-save">Save {{recipeTitle}}</button>
        </div>
    </div>
</template>


<script>
    import NewIngredientForm from './NewIngredientForm.vue';
    import Categories from './resources/Categories.js';
    import Recipes from './resources/Recipes.js';
    import Caret from './assets/caret';
    import AddPlus from './assets/add-plus';
    import XIcon from './assets/x-icon';

    export default {
        components : {
            NewIngredientForm,
            Caret,
            AddPlus,
            XIcon
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
                toggleIngredients     : true,
                prepTime             : '',
                totalTime            : '',
                serves            : '',
                showNeedToBuy : true,
                createDetailsHidden : false,
                createIngredientsHidden : false,
                createDirectionsHidden : false
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
                    directions           : this.directions,
                    prep_time           : this.prepTime,
                    total_time          : this.totalTime,
                    serves              : this.serves
                }).then((response) => {
                    this.$router.push({path : `/recipe/${response.data.id}`});
                });
            },

            addIngredient() {
                if (this.ingredientDescription === '') {
                    return;
                }

                let newIngredient = {full_description : this.ingredientDescription};
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
