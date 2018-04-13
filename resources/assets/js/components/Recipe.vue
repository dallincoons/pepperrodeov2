<template>
        <div class="recipe-wrapper">
            <div class="recipe-heading sm-scrn">
                <h3 class="recipe-title">
                    <span v-if="!editable">{{recipe.title}} </span>
                    <input :value="recipe.title" v-else v-model="recipe.title" class="edit-heading">
                </h3>
                <h5 class="recipe-category">
                    <span v-if="!editable">{{category.title}}</span>
                    <select v-model="recipe.category.id" v-else class="edit-category">
                        <option v-for="category in categories" :value="category.id">{{category.title}}</option>
                    </select>
                </h5>
                <select v-model="groceryListId">
                    <option v-for="list in lists" :value="list.id">{{list.title}}</option>
                </select>  <span @click="addToList">Add to List</span>
            </div>
            <div class="side-section">
                <h4 class="add-ingredient-headings">Ingredients
                    <span @click="addBlankIngredient" v-if="editable" class="add-ingredient-button svg-lgs">
                        <add-icon></add-icon>
                    </span>
                    <span @click="addBlankIngredient" v-if="editable" class="add-ingredient-button svg-sm">
                        <add-icon-dark></add-icon-dark>
                    </span>
                </h4>
                <div class="all-ingredients">
                    <ul class="saved-list-of-ingredients">
                        <li v-for="ingredient in recipe.ingredients" class="ingredient-items">
                            <span v-if="!editable">{{ingredient.description}}</span>
                            <div v-else class="edit-ingredient-wrapper">
                                <input :value="ingredient.description" v-model="ingredient.description" class="edit-ingredient-input">
                                <div v-if="ingredient.id" @click="deleteIngredient(ingredient.id)" class="delete-ingredient svg-lg">
                                    <trash-icon-white></trash-icon-white>
                                </div>
                                <div v-if="ingredient.id" @click="deleteIngredient(ingredient.id)" class="delete-ingredient svg-sm">
                                    <trash-icon width="20" height="20"></trash-icon>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="need-to-buys-section">
                    <h4 class="add-ingredient-headings">Need to Buy
                        <span @click="addBlankListableIngredients" v-if="editable" class="add-ingredient-button svg-lg">
                            <add-icon height="18" width="18"></add-icon>
                        </span>
                        <span @click="addBlankListableIngredients" v-if="editable" class="add-ingredient-button svg-sm">
                            <add-icon height="18" width="18"></add-icon>
                        </span>
                    </h4>
                    <ul class="saved-buy-item-list">
                        <li v-for="listable_ingredient in recipe.listable_ingredients" class="buy-items">
                            <span v-if="!editable">{{listable_ingredient.description}}</span>
                            <div v-else class="edit-ingredient-wrapper">
                                <input :value="listable_ingredient.description" v-model="listable_ingredient.description" class="edit-ingredient-input">
                                <select style="background-color: #3f3f3f" :value="listable_ingredient.department_id" v-model="listable_ingredient.department_id">
                                    <option v-for="department in departments" :value="department.id">{{department.name}}</option>
                                </select>
                                <div v-if="listable_ingredient.id" @click="deleteListableIngredient(listable_ingredient.id)" class="delete-ingredient svg-lg">
                                    <trash-icon-white></trash-icon-white>
                                </div>
                                <div v-if="listable_ingredient.id" @click="deleteListableIngredient(listable_ingredient.id)" class="delete-ingredient svg-sm">
                                    <trash-icon></trash-icon>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-section">
                <div class="recipe-heading lg-scrn">
                    <h3 class="recipe-title">
                        <span v-if="!editable">{{recipe.title}}</span>
                        <input :value="recipe.title" v-else v-model="recipe.title" class="edit-heading">
                    </h3>
                    <h5 class="recipe-category">
                        <span v-if="!editable">{{category.title}}</span>
                        <select v-model="recipe.category.id" v-else class="edit-category">
                            <option v-for="category in categories" :value="category.id">{{category.title}}</option>
                        </select>
                    </h5>
                </div>
                <div class="saved-directions">
                    <h4 class="add-ingredient-headings">Directions</h4>
                    <p class="directions-text">
                        <span v-if="!editable">{{recipe.directions}}</span>
                        <textarea v-else :value="recipe.directions" v-model="recipe.directions" class="edit-directions"></textarea>
                    </p>
                </div>


                <div class="recipe-buttons">
                    <div v-if="editable" @click="updateRecipe" class="edit-button">
                        <save-icon></save-icon>
                    </div>
                    <div v-if="editable" @click="editable=false" class="edit-button">
                        <cancel-icon></cancel-icon>
                    </div>

                    <span v-if="!editable" @click="editable=true" class="modify-button">
                        <edit-icon></edit-icon>
                    </span>
                        <span @click="deleteRecipe" class="modify-button">
                        <trash-icon width="25" height="25"></trash-icon>
                    </span>


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

    export default {
        components : {
            SaveIcon,
            CancelIcon,
            TrashIcon,
            TrashIconWhite,
            AddIcon,
            AddIconDark,
            EditIcon
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
                departments : ''
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
                console.log(this.groceryListId);
                axios.post('api/v1/grocerylist/'+this.groceryListId+'/add-recipe/'+this.recipeId);
            }
        }
    }

</script>
