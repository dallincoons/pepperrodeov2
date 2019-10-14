<template>
        <div class="recipe-wrapper container">
            <div class="recipe-header">
                <h3 class="recipe-title">{{recipe.title}}</h3>
                <p>{{category.title}}</p>
            </div>
            <div class="recipe-details">
                <div class="recipe-detail">
                    <p class="recipe-detail-title">prep time</p>
                    <p class="recipe-detail-info">20 mins</p>
                </div>
                <div class="recipe-detail">
                    <p class="recipe-detail-title">total time</p>
                    <p class="recipe-detail-info">50 mins</p>
                </div>
                <div class="recipe-detail">
                    <p class="recipe-detail-title">serves</p>
                    <p class="recipe-detail-info">4 - 6</p>
                </div>
            </div>
            <div class="recipe-body">
                <div class="recipe-body-header">
                    <h4  @click="toggleRecipeView" class="recipe-body-tab" :class="{'active-tab' : toggleIngredients}">Ingredients</h4>
                    <h4  @click="toggleRecipeView" class="recipe-body-tab" :class="{'active-tab' : toggleDirections}">Directions</h4>
                </div>
                <div class="recipe-body-info">
                    <ul class="recipe-ingredients" :class="{'view-ingredients' : toggleIngredients}">
                        <li v-for="ingredient in recipe.ingredients" class="recipe-ingredient-item">
                            <span v-if="!editable">{{ingredient.full_description}}</span>
                        </li>
                    </ul>
                    <div class="recipe-need-to-buy-wrapper" :class="{'view-ingredients' : toggleIngredients}">
                        <h4 class="recipe-need-to-buy-title" @click="showNeedToBuy = !showNeedToBuy">
                            Need to Buy
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="recipe-chevron" :class="{'chevron-rotate' : !showNeedToBuy}" >
                                <path d="M10.707 7.05L10 6.343 4.343 12l1.414 1.414L10 9.172l4.243 4.242L15.657 12z"/>
                            </svg>
                        </h4>
                        <ul class="recipe-need-to-buy-list" :class="{'recipe-need-to-buy-hidden' : !showNeedToBuy}">
                            <li v-for="listable_ingredient in recipe.listable_ingredients" class="recipe-buy-items">{{listable_ingredient.full_description}}</li>
                        </ul>
                    </div>
                    <p class="recipe-directions" :class="{'view-directions' : toggleDirections}">
                        {{recipe.directions}}
                    </p>
                </div>
            </div>
            <div class="recipe-actions">
                <div class="recipe-action"  @click="toggleAddToList">
                    <div class="recipe-action-icon">
                        <addToList  width="35" height="35" fill="hsl(39, 11%, 69%)"></addToList>
                    </div>
                    <p class="recipe-action-title">Add to List</p>
                </div>
                <div class="recipe-action">
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
            <!--<div>-->
                <!--<div class="recipe-title-categoory-section">-->
                    <!--<h3 class="recipe-title">-->
                        <!--<span v-if="!editable">{{recipe.title}} </span>-->
                        <!--<input v-else v-model="recipe.title" class="edit-heading">-->
                    <!--</h3>-->
                    <!--<h5 class="recipe-category">-->
                        <!--<span v-if="!editable">{{category.title}}</span>-->
                        <!--<select v-model="recipe.category.id" v-else class="edit-category">-->
                            <!--<option v-for="category in categories" :value="category.id">{{category.title}}</option>-->
                        <!--</select>-->
                    <!--</h5>-->
                <!--</div>-->
                <!--<div class="recipe-extra-info">-->
                    <!--<div class="recipe-info">-->
                        <!--<h4 class="recipe-info-title">Prep Time </h4><h4 class="recipe-info-detail">15 min</h4>-->
                    <!--</div>-->
                    <!--<div class="recipe-info">-->
                        <!--<h4 class="recipe-info-title">Total Time </h4><h4 class="recipe-info-detail">45 min</h4>-->
                    <!--</div>-->
                    <!--<div class="recipe-info">-->
                        <!--<h4 class="recipe-info-title">Serves </h4><h4 class="recipe-info-detail">5 - 6</h4>-->
                    <!--</div>-->
                <!--</div>-->

            <!--</div>-->
            <!--<div class="recipe-body">-->
                <!--<h4 @click="toggleRecipeView" class="sm-scrn recipe-ingredient-subheading">Ingredients</h4>-->
                <!--<h4 @click="toggleRecipeView" class="sm-scrn recipe-ingredient-subheading sm-directions-heading">Directions</h4>-->
                <!--<div class="recipe-items" :class="{'view-ingredients' : toggleIngredients}">-->
                    <!--<div class="ingredients-wrapper">-->
                        <!--<h4 class="add-ingredient-headings">Ingredients-->
                            <!--<span @click="addBlankIngredient" v-if="editable" class="add-ingredient-button svg-lgs">-->
                                <!--<add-icon></add-icon>-->
                            <!--</span>-->
                            <!--<span @click="addBlankIngredient" v-if="editable" class="add-ingredient-button svg-sm">-->
                                <!--<add-icon-dark></add-icon-dark>-->
                             <!--</span>-->
                        <!--</h4>-->
                        <!--<div class="all-ingredients">-->
                            <!--<ul class="saved-list-of-ingredients">-->
                                <!--<li v-for="ingredient in recipe.ingredients" class="ingredient-items">-->
                                    <!--<span v-if="!editable">{{ingredient.full_description}}</span>-->
                                    <!--<div v-else class="edit-ingredient-wrapper">-->
                                        <!--<input v-model="ingredient.full_description" class="edit-ingredient-input">-->
                                        <!--<div v-if="ingredient.id" @click="deleteIngredient(ingredient.id)" class="delete-ingredient svg-lg">-->
                                            <!--<trash-icon-white></trash-icon-white>-->
                                        <!--</div>-->
                                        <!--<div v-if="ingredient.id" @click="deleteIngredient(ingredient.id)" class="delete-ingredient svg-sm">-->
                                            <!--<trash-icon width="20" height="20"></trash-icon>-->
                                        <!--</div>-->
                                    <!--</div>-->
                                <!--</li>-->
                            <!--</ul>-->
                        <!--</div>-->
                    <!--</div>-->
                    <!--<div class="need-to-buys-wrapper">-->
                        <!--<div class="need-to-buys-section">-->
                            <!--<div class="need-to-buys-title-section">-->
                                    <!--<h4 class="add-ingredient-headings sm-scrn-heading" @click="showNeedToBuy = !showNeedToBuy">Need to Buy-->
                                        <!--<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="chevron" :class="{'chevron-rotate' : showNeedToBuy}" ><path d="M10.707 7.05L10 6.343 4.343 12l1.414 1.414L10 9.172l4.243 4.242L15.657 12z"/></svg>-->
                                    <!--</h4>-->
                                    <!--<span @click="addBlankListableIngredients" v-if="editable" class="add-ingredient-button svg-lg">-->
                                        <!--<add-icon height="18" width="18"></add-icon>-->
                                    <!--</span>-->
                                    <!--<span @click="addBlankListableIngredients" v-if="editable" class="add-ingredient-button svg-sm">-->
                                        <!--<add-icon height="18" width="18"></add-icon>-->
                                    <!--</span>-->
                            <!--</div>-->
                            <!--<ul class="saved-buy-item-list" :class="{'buy-visible' : showNeedToBuy}">-->
                                <!--<li v-for="listable_ingredient in recipe.listable_ingredients" class="buy-items">-->
                                    <!--<span v-if="!editable">{{listable_ingredient.full_description}}</span>-->
                                    <!--<div v-else class="edit-ingredient-wrapper">-->
                                        <!--<input v-model="listable_ingredient.full_description" class="edit-ingredient-input">-->
                                        <!--<select style="background-color: #3f3f3f"  v-model="listable_ingredient.department_id">-->
                                            <!--<option v-for="department in departments" :value="department.id">{{department.name}}</option>-->
                                        <!--</select>-->
                                        <!--<div v-if="listable_ingredient.id" @click="deleteListableIngredient(listable_ingredient.id)" class="delete-ingredient svg-lg">-->
                                            <!--<trash-icon-white></trash-icon-white>-->
                                        <!--</div>-->
                                        <!--<div v-if="listable_ingredient.id" @click="deleteListableIngredient(listable_ingredient.id)" class="delete-ingredient svg-sm">-->
                                            <!--<trash-icon></trash-icon>-->
                                        <!--</div>-->
                                    <!--</div>-->
                                <!--</li>-->
                            <!--</ul>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</div>-->
                <!--<div class="directions-wrapper" :class="{'view-directions' : toggleDirections}">-->
                    <!--<div class="saved-directions">-->
                        <!--<h4 class="add-ingredient-headings">Directions</h4>-->
                        <!--<p class="directions-text">-->
                            <!--<span v-if="!editable">{{recipe.directions}}</span>-->
                            <!--<textarea v-else v-model="recipe.directions" class="edit-directions"></textarea>-->
                        <!--</p>-->
                    <!--</div>-->
                <!--</div>-->
            <!--</div>-->
            <!--<div class="recipe-actions">-->
                <!--<div class="recipe-action" @click="toggleAddToList">-->
                    <!--<addToList></addToList>-->
                <!--</div>-->
                <!--<div class="recipe-action" v-if="!editable" @click="editable=true">-->
                    <!--<editIcon></editIcon>-->
                <!--</div>-->
                <!--<div v-if="editable" @click="updateRecipe" class="recipe-action">-->
                    <!--<save-icon></save-icon>-->
                <!--</div>-->
                <!--<div v-if="editable" @click="editable=false" class="recipe-action">-->
                    <!--<cancel-icon></cancel-icon>-->
                <!--</div>-->
                <!--<div class="recipe-action">-->
                    <!--<span>SH</span>-->
                <!--</div>-->
                <!--<div class="recipe-action" @click="deleteRecipe">-->
                    <!--<trashIcon></trashIcon>-->
                <!--</div>-->
            <!--</div>-->
            <!--<div class="recipe-options" :class="{'show-options' : addToListVisible}">-->
                <!--<div class="recipe-drop-wrapper" :class="{'show-box' : addToListVisible}">-->
                    <!--<select v-model="groceryListId">-->
                        <!--<option v-for="list in lists" :value="list.id">{{list.title}}</option>-->
                    <!--</select>-->
                    <!--<span @click="addToList">Add to List</span>-->
                <!--</div>-->
            <!--</div>-->
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
                showNeedToBuy : false
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

        methods : {
            getRecipe() {
                Recipe.get(this.recipeId).then((response) => {
                    this.recipe   = response.data;
                    this.category = this.recipe.category;
                });
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
                console.log(this.addToListVisible);
            },

            toggleRecipeView(){
                this.toggleIngredients = !this.toggleIngredients;
                this.toggleDirections = !this.toggleDirections;
            },
        }
    }

</script>
