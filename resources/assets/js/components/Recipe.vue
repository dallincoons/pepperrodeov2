<template>
        <div class="recipe-wrapper container">
            <div class="recipe-section">
                <div class="recipe-header">
                    <h3 class="recipe-title">{{recipe.title | title}}</h3>
                    <p>{{category.title}}</p>
                </div>
                <div class="recipe-details">
                    <div class="recipe-detail">
                        <p class="recipe-detail-title">prep time</p>
                        <p class="recipe-detail-info">{{recipe.prep_time}}</p>
                    </div>
                    <div class="recipe-detail">
                        <p class="recipe-detail-title">total time</p>
                        <p class="recipe-detail-info">{{recipe.total_time}}</p>
                    </div>
                    <div class="recipe-detail">
                        <p class="recipe-detail-title">serves</p>
                        <p class="recipe-detail-info">{{recipe.serves}}</p>
                    </div>
                </div>
                <div class="recipe-body">
                    <div class="recipe-body-header">
                        <h4  @click="toggleRecipeView" class="recipe-body-tab ingredients-tab" :class="{'active-tab' : toggleIngredients}">Ingredients</h4>
                        <h4  @click="toggleRecipeView" class="recipe-body-tab directions-tab" :class="{'active-tab' : toggleDirections}">Directions</h4>
                    </div>
                    <div class="recipe-body-info">
                        <div>
                            <div class="ingredients-wrapper" :class="{'view-ingredients' : toggleIngredients}">
                                <ul class="recipe-ingredients" :class="{'view-ingredients' : toggleIngredients}">
                                    <li v-for="ingredient in recipe.ingredients" class="recipe-ingredient-item">
                                        <span v-if="!editable">{{ingredient.full_description}}</span>
                                    </li>
                                </ul>
                                <div class="sub-recipe-ingredients-wrapper" :class="{'view-sub-recipe' : subRecipeExists}" v-for="subRecipe in subRecipes">
                                    <h4 class="sub-ingredients-section-title" :class="{'view-ingredients' : toggleIngredients}">{{subRecipe.title | title}} Ingredients</h4>
                                    <ul class="recipe-ingredients" :class="{'view-ingredients' : toggleIngredients}">
                                        <li v-for="ingredient in subRecipe.ingredients" class="recipe-ingredient-item">
                                            <span v-if="!editable">{{ingredient.full_description}}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="recipe-need-to-buy-wrapper" :class="{'hide-need-to-buy' : toggleDirections}">
                                <h4 class="recipe-need-to-buy-title" @click="showNeedToBuy = !showNeedToBuy">
                                    Need to Buy
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="recipe-chevron" :class="{'chevron-rotate' : !showNeedToBuy}" >
                                        <path d="M10.707 7.05L10 6.343 4.343 12l1.414 1.414L10 9.172l4.243 4.242L15.657 12z"/>
                                    </svg>
                                </h4>
                                <ul class="recipe-need-to-buy-list" :class="{'recipe-need-to-buy-hidden' : !showNeedToBuy}">
                                    <li v-for="listable_ingredient in recipe.listable_ingredients" class="recipe-buy-items" :class="[{'recipe-need-to-buy-hidden' : !showNeedToBuy}, {'view-ingredients' : subRecipeExists}]">{{listable_ingredient.full_description}}</li>
                                </ul>
                                <div class="sub-recipe-need-buy-wrapper" :class="[{'recipe-need-to-buy-hidden' : !showNeedToBuy}, {'view-sub-recipe' : subRecipeExists}]" v-for="subRecipe in subRecipes">
                                    <h4 class="sub-ingredients-section-title" :class="[{'recipe-need-to-buy-hidden' : !showNeedToBuy}, {'view-ingredients' : subRecipeExists}]">{{subRecipe.title | title}} Need To Buys</h4>
                                    <ul class="recipe-ingredients" :class="[{'recipe-need-to-buy-hidden' : !showNeedToBuy}, {'view-ingredients' : subRecipeExists}]">
                                        <li v-for="ingredient in subRecipe.ingredients" class="recipe-ingredient-item" :class="[{'recipe-need-to-buy-hidden' : !showNeedToBuy}, {'view-ingredients' : subRecipeExists}]">
                                            <span v-if="!editable">{{ingredient.full_description}}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="recipe-directions" :class="{'view-directions' : toggleDirections}">
                                <p class="recipe-source" v-if="!sourceIsUrl">{{recipe.source}}</p>
                                <a class="recipe-source" :class="{sourceIsUrl : sourceIsUrl}" v-if="sourceIsUrl" v-bind:href="recipe.source" target="_blank">{{recipe.source}}</a>
                                <p>{{recipe.directions}}</p>
                                <div class="sub-recipe-directions" :class="{'hide-sub-recipe' : !subRecipeExists}" v-for="subRecipe in subRecipes">
                                    <h4>{{subRecipe.title | title}} Directions</h4>
                                    <p>{{subRecipe.directions}}</p>
                                </div>
                            </div>
                            <div class="linked-recipes-on-recipe" v-if="linkedRecipesExist">
                                <h4>Linked Recipes</h4>
                                <ul class="linked-recipes-list-on-recipe">
                                    <li v-for="recipe in linkedRecipes">
                                        <router-link :to="{name: 'recipe', params: {id : recipe.id}}">{{recipe.title}}</router-link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="recipe-actions">
                    <div class="recipe-action"  @click="toggleAddToList">
                        <div class="recipe-action-icon">
                            <addToList  width="35" height="35" fill="hsl(39, 11%, 69%)"></addToList>
                        </div>
                        <p class="recipe-action-title">Add to List</p>
                    </div>
                    <div class="recipe-action" @click="editRecipe(recipeId)">
                        <div class="recipe-action-icon">
                            <edit-icon width="35" height="35" fill="hsl(39, 11%, 69%)"></edit-icon>
                        </div>
                        <p class="recipe-action-title">Edit {{recipeTitle}}</p>
                    </div>
                    <div class="recipe-action" @click="deleteRecipe">
                        <div class="recipe-action-icon">
                            <trash-icon width="35" height="35" fill="hsl(39, 11%, 69%)"></trash-icon>
                        </div>
                        <p class="recipe-action-title">Delete {{recipeTitle}}</p>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>

    import Recipe from './resources/Recipes.js';
    import Categories from './resources/Categories.js';
    import Ingredients from './resources/Ingredients.js';
    import ListableIngredients from './resources/ListableIngredients.js';

    //Assets
    import SaveIcon from './assets/save-icon.vue';
    import CancelIcon from './assets/cancel-icon.vue';
    import TrashIcon from './assets/trashcan.vue';
    import TrashIconWhite from './assets/trashcan-white.vue';
    import AddIcon from './assets/add-icon.vue';
    import AddIconDark from './assets/add-icon-dark.vue';
    import EditIcon from './assets/edit-icon.vue';
    import AddToList from './assets/add-to-list.vue';

    export default {
        components : {
            SaveIcon,
            CancelIcon,
            TrashIcon,
            TrashIconWhite,
            AddIcon,
            AddIconDark,
            EditIcon,
            AddToList,

        },

        data() {
            return {
                recipe      : {},
                subRecipes : [],
                category    : {},
                editable : false,
                categories  : [],
                groceryListId : '',
                recipeId : '',
                lists : [],
                departments : '',
                addToListVisible : false,
                toggleIngredients : true,
                toggleDirections : false,
                showNeedToBuy : false,
                recipeTitle : '',
                sourceIsUrl : false,
                linkedRecipes : [],
                // linkedRecipesExist: false,
            }
        },

        mounted() {
            this.recipeId = this.$route.params.id;
            this.getRecipe();

            Categories.all().then((response) => {
                this.categories = response.data;
            });

            axios.get('/api/v1/grocery-lists').then((response) => {
                this.lists = response.data.data;
            });

            axios.get('/api/v1/departments').then((response) => {
                this.departments = response.data;
            });


        },

        computed : {
            subRecipeExists: function() {
                return this.subRecipes.length > 0;
            },

            subRecipe: function() {
                if (this.subRecipes.length === 0) {
                    return {
                        directions: "Looks like there's no directions",
                        ingredients: [],
                        listable_ingredients: [],
                    }
                }

                return this.subRecipes[0];
            },

            linkedRecipesExist: function() {
                return this.linkedRecipes.length > 0;
            },

            setSourceType: function(){
                if (this.recipe.source_type === 2) {
                    this.sourceIsUrl = true;
                }
            }
        },

        filters: {
            title(value){
                if (!value) {
                    return;
                }
                return value.replace(/(?:^|\s|-)\S/g, x => x.toUpperCase());
            }
        },

        methods : {
            getRecipe() {
                Recipe.get(this.recipeId).then((response) => {
                    this.recipe   = response.data.recipe;
                    this.subRecipes = response.data.sub_recipes;
                    this.category = this.recipe.category;
                    this.recipeTitle = this.recipe.title;
                    if (this.recipe.linked_recipes) {
                        this.linkedRecipes = this.recipe.linked_recipes;
                    }
                });
            },

            editRecipe(recipeId) {
                this.$router.push({path: `/recipe/${recipeId}/edit`})
            },

            deleteRecipe() {
                let deleteConfirm = confirm("Are you sure you want to delete " + this.recipe.title);
                if (deleteConfirm === false) {
                    return;
                }

                Recipe.delete(this.recipeId).then(response => {
                    if (response.status === 200) {
                        this.$router.push({path : `/recipes`});
                    }
                })
            },

            updateRecipe() {
                Recipe.update(this.recipeId, {
                    title       : this.recipe.title,
                    directions  : this.recipe.directions,
                    category_id : this.recipe.category.id,
                    ingredients : this.recipe.ingredients,
                    listable_ingredients : this.recipe.listable_ingredients
                }).then((response) => {
                    this.getRecipe();
                    this.editable = false;
                });
            },

            addBlankIngredient() {
                this.recipe.ingredients.push({});
            },

            addBlankListableIngredients() {
                this.recipe.listable_ingredients.push({});
            },

            deleteIngredient(id) {
                Ingredients.delete(id).then(response => {
                    this.getRecipe();
                });
            },

            deleteListableIngredient(id) {
                ListableIngredients.delete(id).then(response => {
                    this.getRecipe();
                });
            },

            addToList() {
                axios.post('api/v1/grocerylist/'+this.groceryListId+'/add-recipe/'+this.recipeId);
            },

            toggleAddToList(){
                this.addToListVisible = !this.addToListVisible;
            },

            toggleRecipeView(){
                this.toggleIngredients = !this.toggleIngredients;
                this.toggleDirections = !this.toggleDirections;
            },

        }
    }

</script>
