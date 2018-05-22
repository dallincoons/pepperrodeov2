<template>
    <div class="recipe-wrapper">
        <div class="recipe-header">
            <div class="recipe-title-cat-add">
                <div class="grid-row-1">
                    <div class="grid-item"><span class="grid-label">Title</span><input type="text" required v-model="recipeTitle"></div>
                    <div class="grid-item"><span class="grid-label">Category</span>
                        <select v-model="selectedCategory" class="recipe-category-select">
                            <option v-for="category in  categories" :value="category.id">{{category.title}}</option>
                        </select>
                    </div>
                </div>
                <div class="grid-row-2">
                    <div class="grid-item"><span class="grid-label">Prep Time</span><input type="text" v-model="prepTime"></div>
                    <div class="grid-item"><span class="grid-label">Total Time</span><input type="text" v-model="totalTime"></div>
                    <div class="grid-item"><span class="grid-label">Serves</span><input type="text" v-model="serves"></div>
                </div>
            </div>
        </div>
        <div class="recipe-body">
            <h4 @click="toggleIngredients = true" class="sm-scrn recipe-ingredient-subheading">Ingredients </h4>
            <h4 @click="toggleIngredients = false" class="sm-scrn recipe-directions-subheading">Directions</h4>
            <div class="recipe-items" :class="{showItems : toggleIngredients}">
                <div class="ingredients-wrapper">
                    <h4 class="add-ingredient-headings">Ingredients <span @click="addIngredient" class="add-ingredient-button"><add-icon-dark></add-icon-dark></span></h4>
                    <input class="ingredient-input" v-model="ingredientDescription" @keyup.enter="addIngredient" > <span @click="addIngredient" class="add-ingredient-button-sm"><add-icon-dark></add-icon-dark></span>
                    <ul class="saved-list-of-ingredients">
                        <li v-for="(ingredient, index) in ingredients" class="ingredient-items">{{ingredient.description}} <div @click="deleteIngredient(index)"><trash-can></trash-can></div></li>
                    </ul>
                </div>
                <div class="need-to-buys-wrapper">
                    <div class="need-to-buys-section">
                        <h4 class="add-ingredient-headings sm-scrn-heading" @click="showNeedToBuy = !showNeedToBuy">Need to Buy
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="chevron" :class="{'chevron-rotate' : showNeedToBuy}" ><path d="M10.707 7.05L10 6.343 4.343 12l1.414 1.414L10 9.172l4.243 4.242L15.657 12z"/></svg>
                        </h4>

                        <ul class="saved-buy-item-list" :class="{'buy-visible' : showNeedToBuy}">
                            <li v-for="(needToBuy, index) in needToBuys" class="buy-items">{{needToBuy.description}}<div @click="deleteNeedToBuy(index)"><trash-can></trash-can></div></li>
                        </ul>
                    </div>

                </div>
            </div>
            <div class="directions-wrapper" :class="[toggleIngredients ? '' : 'showItems' ]">
                <div class="saved-directions">
                    <h4 class="add-ingredient-headings">Directions</h4>
                    <textarea v-model="directions"></textarea>
                </div>
                <div class="">
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

    export default {
        components : {
            AddIcon,
            NewIngredientForm,
            TrashCan,
            AddIconDark
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
                showNeedToBuy : false,
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
