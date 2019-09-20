<template>
    <div class="create-recipe-wrapper">
        <h2 class="create-recipe-page-title">Create Recipe</h2>
        <div class="create-recipe-section-wrapper">
            <div class="create-recipe-header">
                <h4>Recipe Details</h4>
                <span class="create-caret"><caret></caret></span>
            </div>
            <div class="create-recipe-body">
                <div class="create-recipe-title recipe-item">
                    <span class="create-recipe-label">Title</span>
                    <input type="text" required v-model="recipeTitle" class="create-recipe-input">
                </div>
                <div class="create-recipe-category recipe-item">
                    <span class="create-recipe-label">Category</span>
                    <ul class="create-recipe-category-list">
                        <li v-for="category in  categories" class="create-recipe-category-list-item">
                            <span class="create-recipe-radio-button"></span>
                            <input :value="category.id" type="radio" v-model="selectedCategory" id="create-recipe-radio-button" class="create-recipe-category-radio">
                            <label for="create-recipe-radio-button" class="create-recipe-radio-label">{{category.title}}</label>
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
            <div class="create-recipe-header">
                <h4>{{recipeTitle}} Ingredients</h4>
                <span class="create-caret"><caret></caret></span>
            </div>
            <div class="create-recipe-body">
                <div class="recipe-items" :class="{showItems : toggleIngredients}">
                    <div class="create-recipe-ingredients-wrapper">
                        <label class="create-recipe-label recipe-item">Add Ingredients</label>
                        <div class="create-recipe-add-ingredient-section">
                            <input class="create-ingredient-input" v-model="ingredientDescription" @keyup.enter="addIngredient" >
                            <span @click="addIngredient" class="add-ingredient-button"></span>
                        </div>

                        <ul class="saved-list-of-ingredients recipe-item">
                            <li v-for="(ingredient, index) in ingredients" class="ingredient-items">{{ingredient.full_description}} <div @click="deleteIngredient(index)"><trash-can></trash-can></div></li>
                        </ul>
                    </div>
                    <div class="need-to-buys-wrapper">
                        <div class="need-to-buys-section">
                            <h4 class="add-ingredient-headings sm-scrn-heading" @click="showNeedToBuy = !showNeedToBuy">Need to Buy
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="chevron" :class="{'chevron-rotate' : showNeedToBuy}" ><path d="M10.707 7.05L10 6.343 4.343 12l1.414 1.414L10 9.172l4.243 4.242L15.657 12z"/></svg>
                            </h4>

                            <ul class="saved-buy-item-list" :class="{'buy-visible' : showNeedToBuy}">
                                <li v-for="(needToBuy, index) in needToBuys" class="buy-items">{{needToBuy.full_description}}<div @click="deleteNeedToBuy(index)"><trash-can></trash-can></div></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--<div class="create-recipe-header">-->
            <!--<div class="recipe-details">-->
                <!--<div class="create-recipe-title recipe-item">-->
                    <!--<span class="create-recipe-label">Title</span>-->
                    <!--<input type="text" required v-model="recipeTitle" class="create-recipe-input">-->
                <!--</div>-->
                <!--<div class="create-recipe-category recipe-item">-->
                    <!--<span class="create-recipe-label">Category</span>-->
                    <!--<ul>-->
                        <!--<li v-for="category in  categories" ><input :value="category.id" type="radio" v-model="selectedCategory">{{category.title}}</li>-->
                    <!--</ul>-->
                <!--</div>-->
                <!--<div class="create-recipe-prep recipe-item">-->
                    <!--<span class="create-recipe-label">Prep Time</span>-->
                    <!--<input type="text" v-model="prepTime" class="create-recipe-input">-->
                <!--</div>-->
                <!--<div class="create-recipe-total recipe-item">-->
                    <!--<span class="create-recipe-label">Total Time</span>-->
                    <!--<input type="text" v-model="totalTime" class="create-recipe-input">-->
                <!--</div>-->
                <!--<div class="create-recipe-serves recipe-item">-->
                    <!--<span class="create-recipe-label">Serves</span>-->
                    <!--<input type="text" v-model="serves" class="create-recipe-input">-->
                <!--</div>-->
            <!--</div>-->
        <!--</div>-->
        <div class="recipe-body">
            <!--<h4 @click="toggleIngredients = true" class="sm-scrn recipe-ingredient-subheading">Ingredients </h4>-->
            <h4 @click="toggleIngredients = false" class="sm-scrn recipe-directions-subheading">Directions</h4>
            <div class="recipe-items" :class="{showItems : toggleIngredients}">
                <!--<div class="ingredients-wrapper">-->
                    <!--<h4 class="add-ingredient-headings">Ingredients <span @click="addIngredient" class="add-ingredient-button"><add-icon-dark></add-icon-dark></span></h4>-->
                    <!--<input class="ingredient-input" v-model="ingredientDescription" @keyup.enter="addIngredient" > <span @click="addIngredient" class="add-ingredient-button-sm"><add-icon-dark></add-icon-dark></span>-->
                    <!--<ul class="saved-list-of-ingredients">-->
                        <!--<li v-for="(ingredient, index) in ingredients" class="ingredient-items">{{ingredient.full_description}} <div @click="deleteIngredient(index)"><trash-can></trash-can></div></li>-->
                    <!--</ul>-->
                <!--</div>-->
                <!--<div class="need-to-buys-wrapper">-->
                    <!--<div class="need-to-buys-section">-->
                        <!--<h4 class="add-ingredient-headings sm-scrn-heading" @click="showNeedToBuy = !showNeedToBuy">Need to Buy-->
                            <!--<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="chevron" :class="{'chevron-rotate' : showNeedToBuy}" ><path d="M10.707 7.05L10 6.343 4.343 12l1.414 1.414L10 9.172l4.243 4.242L15.657 12z"/></svg>-->
                        <!--</h4>-->

                        <!--<ul class="saved-buy-item-list" :class="{'buy-visible' : showNeedToBuy}">-->
                            <!--<li v-for="(needToBuy, index) in needToBuys" class="buy-items">{{needToBuy.full_description}}<div @click="deleteNeedToBuy(index)"><trash-can></trash-can></div></li>-->
                        <!--</ul>-->
                    <!--</div>-->

                <!--</div>-->
            </div>
            <div class="directions-wrapper" :class="[toggleIngredients ? '' : 'showItems' ]">
                <div class="saved-directions">
                    <h4 class="add-ingredient-headings">Directions</h4>
                    <textarea v-model="directions" class="directions-textarea"></textarea>
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
    import TrashCan from './assets/trashcan.vue';
    import Categories from './resources/Categories.js';
    import Recipes from './resources/Recipes.js';
    import AddIcon from "./assets/add-icon";
    import AddIconDark from './assets/add-icon-dark';
    import Caret from './assets/caret';

    export default {
        components : {
            AddIcon,
            NewIngredientForm,
            TrashCan,
            AddIconDark,
            Caret
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
