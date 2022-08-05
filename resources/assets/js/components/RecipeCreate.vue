<template>
    <div class="create-recipe-start container" v-if="editing === false">
        <section class="create-recipe-section-wrapper">
            <div class="create-recipe-header">
                <h4>Create Recipe</h4>
            </div>
            <section class="create-recipe-start-items">
                <div class="create-recipe-title recipe-item">
                    <span class="create-recipe-label">Title:</span>
                    <input type="text" required v-model="recipeTitle" class="create-recipe-input">
                </div>
                <div class="create-recipe-category recipe-item">
                    <span class="create-recipe-label">Category:</span>
                    <ul class="create-recipe-category-list">
                        <li v-for="category in  categories" class="create-recipe-category-list-item">
                            <input type="checkbox" name="create-radio" :value="category.id" v-model="selectedCategories" class="create-recipe-radio-button">
                            <label class="create-recipe-radio-label">{{category.title}}</label>
                        </li>
                    </ul>
                </div>
            </section>

            <button @click="saveAndContinue()" class="create-recipe-save">Next ➔</button>
        </section>
    </div>
    <div v-else class="create-recipe-wrapper">
        <div class="create-recipe-section-wrapper">
            <div class="create-recipe-header">
                <h4>Recipe Details</h4>
            </div>
            <div class="create-recipe-body">
                <div class="create-recipe-title recipe-item">
                    <span class="create-recipe-label">Title:</span>
                    <input type="text" v-debounce:500ms="saveRecipe" required v-model="recipeTitle" class="create-recipe-input">
                </div>
                <div class="create-recipe-category recipe-item">
                    <span class="create-recipe-label">Category:</span>
                    <ul class="create-recipe-category-list">
                        <li v-for="category in  categories" class="create-recipe-category-list-item">
                            <input @change="saveRecipe" type="checkbox" name="create-radio" :value="category.id"  v-model="selectedCategories" class="create-recipe-radio-button">
                            <label class="create-recipe-radio-label">{{category.title}}</label>
                        </li>
                    </ul>
                </div>
                <div class="create-recipe-details-numbers">
                    <div class="create-recipe-prep recipe-item">
                        <span class="create-recipe-label">Prep Time</span>
                        <input v-debounce:500ms="saveRecipe" type="text" v-model="prepTime" class="create-recipe-input">
                    </div>
                    <div class="create-recipe-total recipe-item">
                        <span class="create-recipe-label">Total Time</span>
                        <input v-debounce:500ms="saveRecipe"  type="text" v-model="totalTime" class="create-recipe-input">
                    </div>
                    <div class="create-recipe-serves recipe-item">
                        <span class="create-recipe-label">Serves</span>
                        <input v-debounce:500ms="saveRecipe"  type="text" v-model="serves" class="create-recipe-input">
                    </div>
                </div>
                <div class="recipe-item">
                    <span class="create-recipe-label">Source</span>
                    <input type="text" v-debounce:500ms="saveRecipe"  v-model="source" placeholder="Website? Book?" class="create-recipe-input">
                </div>
                <div class="add-subsection-check-wrapper">
                    <div class="recipe-extra-wrapper">
                        <button  @click="createSubRecipe()" class="recipe-extra-button"><add-plus class="create-recipe-add-plus"></add-plus></button><p>Add a sub-recipe</p>
                    </div>
                    <div class="recipe-extra-wrapper link-recipe">
                        <div class="link-recipe-button-wrapper"><button  @click="getRecipes(); addRecipesOpen = !addRecipesOpen" class="recipe-extra-button"><add-plus class="create-recipe-add-plus"></add-plus></button><p>Link recipes</p></div>
                        <div class="link-recipe-search-section">
                            <div class="list-add-recipes-wrapper" :class="{'list-show-recipes' : addRecipesOpen}">
                                <div class="list-add-recipes-body">
                                    <div class="list-add-recipes-recipes-section">
                                        <div class="list-add-recipes-header">
                                            <div class="search-wrapper list-search">
                                                <input
                                                        type="search"
                                                        name="recipeSearch"
                                                        placeholder="Search"
                                                        v-model="itemSearchedFor"
                                                        v-on:keyup.enter="searchRecipes(itemSearchedFor)"
                                                        class="recipe-input search-box"
                                                >
                                                <button class="close-icon" type="reset" @click="clearSearch()"><x-icon style="width: 15px; height: 15px" class="search-x-icon" :class="{closeIconVisible : itemSearchedFor.length > 0}"></x-icon></button>
                                                <button @click="searchRecipes(itemSearchedFor)" class="search-button"><search class="search-icon"></search></button>
                                                <button @click="saveLinkedRecipes" class="create-recipe-save">Link</button>
                                            </div>
                                        </div>
                                        <div class="category-container">
                                            <ul class="list-add-recipes-list">
                                                <li v-for="recipe in recipes" class="list-add-recipes-item">
                                                    <div class="fs-checkbox">
                                                        <input type="checkbox" :id="'checkbox_' + recipe.id" :value="recipe.id" v-model="checkedRecipes">
                                                        <label :for="'checkbox_' + recipe.id">{{recipe.title}}</label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="list-add-recipes-wrapper" :class="{'list-show-recipes' : recipesLinked}">
                            <span class="create-recipe-label">Linked Recipes</span>
                                <ul class="linked-recipes-list">
                                    <li v-for="recipe in linkedRecipes" class="linked-recipes">
                                        <router-link :to="{name: 'recipe', params: {id : recipe.id}}">{{recipe.title}}</router-link>
                                        <span @click="removeLinkedRecipe(recipe.id)"><x-icon  class="linked-recipes-x"></x-icon></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="create-recipe-section-wrapper">
            <div class="create-recipe-header">
                <h4>{{recipeTitle}} Ingredients</h4>
            </div>
            <div class="create-recipe-body">
                <div class="create-recipe-ingredients-ntb-wrapper">
                    <div class="create-recipe-ingredients-wrapper">
                        <label class="create-recipe-label">Add Ingredients:</label>
                        <div class="create-recipe-add-ingredient-section">
                            <input v-debounce:500ms="saveRecipe" class="create-ingredient-input" v-model="ingredientDescription" @keyup.enter="addIngredient" >
                            <span @click="addIngredient" class="add-ingredient-button"><add-plus class="create-recipe-add-plus"></add-plus></span>
                        </div>

                        <ul class="recipe-item">
                            <li v-for="(ingredient, index) in ingredients" class="create-ingredient-items">
                                <input v-debounce:500ms="saveRecipe" class="recipe-item-input" v-model="ingredient.full_description">
                                <div @click="deleteIngredient(index)" class="x-icon"><x-icon class="x-icon-svg"></x-icon></div>
                            </li>
                        </ul>
                    </div>
                    <div class="need-to-buys-wrapper">
                        <div class="need-to-buys-section">
                            <label class="create-recipe-label create-recipe-need-to-buy-title" @click="showNeedToBuy = !showNeedToBuy">
                                Need to Buy
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="chevron buys-chevron" :class="{'chevron-rotate' : showNeedToBuy}" ><path d="M10.707 7.05L10 6.343 4.343 12l1.414 1.414L10 9.172l4.243 4.242L15.657 12z"/></svg>
                            </label>


                            <ul class="recipe-item create-recipe-buy-list" :class="{'buy-visible' : showNeedToBuy}">
                                <li v-for="(needToBuy, index) in needToBuys" class="create-ingredient-items">
                                    <input v-debounce:500ms="saveRecipe" class="recipe-item-input" v-model="needToBuy.full_description">
                                    <select @change="saveRecipe" class="need-buy-department"  v-model="needToBuy.department_id">
                                        <option v-for="department in departments" :value="department.id">{{department.name}}</option>
                                    </select>
                                    <div @click="deleteNeedToBuy(index)" class="x-icon"><x-icon class="x-icon-svg"></x-icon></div>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="create-recipe-section-wrapper">
            <div class="create-recipe-header">
                <h4>{{recipeTitle}} Directions</h4>
            </div>
            <div class="create-recipe-body">
                <div class="create-recipe-title recipe-item">
                    <span class="create-recipe-label">Add Directions:</span>
                    <textarea v-model="directions" v-debounce:500ms="saveRecipe" class="create-recipe-input create-recipe-textarea"></textarea>
                    <span class="create-recipe-label add-notes-label">Additional Notes:</span>
                    <textarea v-model="notes" v-debounce:500ms="saveRecipe" class="create-recipe-input create-recipe-textarea add-notes"></textarea>
                </div>
            </div>
        </div>
        <div class="subsection-wrapper" v-for="(subRecipe, subRecipeIndex) in subRecipes">
        <span @click="removeSubRecipe(subRecipe[subRecipeIndex])" class="remove-subrecipe"><XIcon></XIcon></span>
            <div class="create-recipe-section-wrapper">
                <div class="create-recipe-header">
                    <h4>Sub Recipe Details</h4>
                </div>
                <div class="create-recipe-body" >
                    <div class="create-recipe-title recipe-item">
                        <span class="create-recipe-label">Title:</span>
                        <input type="text" v-debounce:500ms="saveRecipe" required v-model="subRecipes[subRecipeIndex].title" class="create-recipe-input">
                    </div>
                </div>
            </div>

            <div class="create-recipe-section-wrapper">
                <div class="create-recipe-header" >
                    <h4>Sub Recipe Ingredients</h4>
                </div>
                <div class="create-recipe-body">
                    <div class="create-recipe-ingredients-ntb-wrapper">
                        <div class="create-recipe-ingredients-wrapper">
                            <label class="create-recipe-label">Add Ingredients:</label>
                            <div class="create-recipe-add-ingredient-section">
                                <input v-debounce:500ms="saveRecipe" class="create-ingredient-input" v-model="subIngredientInput[subRecipeIndex]" @keyup.enter="addSubIngredient(subRecipeIndex)" >
                                <span @click="addSubIngredient(subRecipeIndex)" class="add-ingredient-button"><add-plus class="create-recipe-add-plus"></add-plus></span>
                            </div>

                            <ul class="recipe-item">
                                <li v-for="(subIngredient, index) in subRecipe.ingredients" class="create-ingredient-items">
                                    <input v-debounce:500ms="saveRecipe" class="recipe-item-input" v-model="subIngredient.full_description">
                                    <div @click="deleteSubIngredient(subRecipes[subRecipeIndex], index)" class="x-icon"><x-icon class="x-icon-svg"></x-icon></div>
                                </li>
                            </ul>
                        </div>
                        <div class="need-to-buys-wrapper">
                            <div class="need-to-buys-section">
                                <label class="create-recipe-label create-recipe-need-to-buy-title" @click="showSubNeedToBuy = !showSubNeedToBuy">
                                    Need to Buy
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="chevron buys-chevron" :class="{'chevron-rotate' : showSubNeedToBuy}"><path d="M10.707 7.05L10 6.343 4.343 12l1.414 1.414L10 9.172l4.243 4.242L15.657 12z"/></svg>
                                </label>

                                <ul class="recipe-item create-recipe-buy-list" :class="{'buy-visible' : showSubNeedToBuy}">
                                    <li v-for="(subNeedToBuy, index) in subRecipe.needToBuys" class="create-ingredient-items">
                                        <input v-debounce:500ms="saveRecipe" class="recipe-item-input" v-model="subNeedToBuy.full_description">
                                        <select @change="saveRecipe"  class="need-buy-department"  v-model="subNeedToBuy.department_id">
                                            <option v-for="department in departments" :value="department.id">{{department.name}}</option>
                                        </select>
                                        <div @click="deleteSubNeedToBuy(subRecipes[subRecipeIndex], index)" class="x-icon"><x-icon class="x-icon-svg"></x-icon></div>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="create-recipe-section-wrapper">
                <div class="create-recipe-header">
                    <h4>Sub Recipe Directions</h4>
                </div>
                <div class="create-recipe-body">
                    <div class="create-recipe-title recipe-item">
                        <span class="create-recipe-label">Add Directions:</span>
                        <textarea v-debounce:500ms="saveRecipe" v-model="subRecipes[subRecipeIndex].directions" class="create-recipe-input create-recipe-textarea"></textarea>
                        <span class="create-recipe-label">Additional Notes:</span>
                        <textarea v-debounce:500ms="saveRecipe" v-model="subRecipes[subRecipeIndex].notes" class="create-recipe-input create-recipe-textarea add-notes"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="create-recipe-section-buttons">
            <button @click="showRecipe" class="create-recipe-save">Done</button>
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
    import Search from './assets/search'

    const UNASSIGNED_DEPARTMENT = 1;

    export default {
        components: {
            NewIngredientForm,
            Caret,
            AddPlus,
            XIcon,
            Search
        },

        props: {
            editing: Boolean
        },

        data() {
            return {
                recipeTitle: '',
                selectedCategories: [],
                categories: [],
                ingredientDescription: '',
                ingredients: [],
                needToBuys: [],
                directions: '',
                notes: '',
                source: '',
                departments: '',
                prepTime: '',
                totalTime: '',
                serves: '',
                showNeedToBuy: true,
                subRecipes: [],
                showSubNeedToBuy: true,
                subIngredientInput: [],
                addRecipesOpen: false,
                recipesLinked: false,
                recipes: [],
                itemSearchedFor: '',
                checkedRecipes: [],
                recipeMap: {},
                linkedRecipes: [],
                step: 'begin',
            }
        },

        mounted() {
            Categories.all().then((response) => {
                this.categories = response.data;
            });
            axios.get('/api/v1/departments').then((response) => {
                this.departments = response.data;
            });

            if (this.editing) {
                this.populateRecipeFields()
            }

            this.getRecipes((recipes) => {
                recipes.forEach((recipe) => {
                    this.recipeMap[recipe.id] = recipe;
                });
            });

        },
        methods: {
            getRecipes(then) {
                axios.get('/api/v1/recipes').then((response) => {
                    this.recipes = response.data;
                    then(this.recipes);
                });
            },

            saveRecipe() {
                if (this.editing) {
                    this.updateRecipe();
                    return;
                }

                if (this.selectedCategories.length === 0) {
                    alert('Please choose at least one category!');
                    return;
                }

                return Recipes.save(this.getRecipeFacts());
            },

            showRecipe() {
                this.$router.push({path: `/recipe/${this.$route.params.id}`});
            },

            saveAndContinue()  {
                this.saveRecipe().then((response) => {
                    this.$router.push({path: `/recipe/${response.data.id}/edit`});
                });
            },

            updateRecipe() {
                let recipeFacts = this.getRecipeFacts();

                return Recipes.update(this.$route.params.id, recipeFacts);
            },

            getRecipeFacts() {
                let recipeFacts = {
                    title: this.recipeTitle,
                    categories: this.selectedCategories,
                    ingredients: this.ingredients,
                    listable_ingredients: this.needToBuys,
                    directions: this.directions,
                    notes: this.notes,
                    prep_time: this.prepTime,
                    total_time: this.totalTime,
                    serves: this.serves,
                    source: this.source,
                    sourceType: this.source_type,
                };

                if (this.createSubRecipe) {
                    //@todo add sub recipe validation
                    recipeFacts['sub_recipes'] = this.subRecipes;
                }

                if (this.linkedRecipes) {
                    recipeFacts['linked_recipes'] = this.checkedRecipes;
                }

                return recipeFacts;
            },

            createSubRecipe() {
                if(this.subRecipes.length > 0) {
                    for (let recipe of this.subRecipes) {
                        if(recipe.title.length < 1){
                            alert('You already have an unused sub-recipe. Give it a title. :)');
                            return;
                        }
                    }
                }

                let newSubRecipe = {
                    title: '',
                    ingredients: [],
                    needToBuys: [],
                    directions: '',
                    notes: '',
                };
                this.subIngredientInput.push('');
                this.subRecipes.push(newSubRecipe);
            },

            removeSubRecipe(id) {
                this.subRecipes.splice(id, 1);

                this.saveRecipe();
            },

            addIngredient() {
                if (this.ingredientDescription === '') {
                    return;
                }

                let newIngredient = {full_description: this.ingredientDescription};
                this.ingredients.push(newIngredient);
                this.needToBuys.push(Object.assign({department_id: UNASSIGNED_DEPARTMENT}, newIngredient));
                this.ingredientDescription = '';

                this.saveRecipe();
            },

            addSubIngredient(subRecipeIndex) {
                if (this.subIngredientInput[subRecipeIndex] === '') {
                    return;
                }
                let newIngredient = {full_description: this.subIngredientInput[subRecipeIndex]};
                this.subRecipes[subRecipeIndex].ingredients.push(newIngredient);
                this.subRecipes[subRecipeIndex].needToBuys.push(Object.assign({department_id: UNASSIGNED_DEPARTMENT}, newIngredient));
                this.subIngredientInput[subRecipeIndex] = '';

                this.saveRecipe();
            },

            deleteIngredient(index) {
                this.ingredients.splice(index, 1);

                this.saveRecipe();
            },

            deleteNeedToBuy(index) {
                this.needToBuys.splice(index, 1);

                this.saveRecipe();
            },

            deleteSubIngredient(subRecipe, index) {
                subRecipe.ingredients.splice(index, 1);

                this.saveRecipe();
            },

            deleteSubNeedToBuy(subRecipe, index) {
                subRecipe.needToBuys.splice(index, 1);

                this.saveRecipe();
            },

            populateRecipeFields() {
                Recipes.get(this.$route.params.id).then((response) => {
                    let recipe = response.data.recipe;
                    this.recipeTitle = recipe.title;
                    this.directions = recipe.directions;
                    this.notes  = recipe.notes;
                    this.selectedCategories = recipe.categories.map(cat => cat.id);
                    this.ingredients = recipe.ingredients;
                    this.needToBuys = recipe.listable_ingredients;
                    this.prepTime = recipe.prepTime;
                    this.totalTime = recipe.totaltime;
                    this.serves = recipe.serves;
                    this.source = recipe.source;
                    this.sourceType = recipe.source_type;
                    this.linkedRecipes = recipe.linked_recipes;
                    this.checkedRecipes = this.addLinkedToChecked();
                    if(this.linkedRecipes.length > 0) {
                        this.recipesLinked = true;
                    }
                    this.subRecipes = this.subRecipeResponseTranslate(response.data.sub_recipes);
                })
            },

            subRecipeResponseTranslate(subRecipes) {
                return subRecipes.map(subRecipe => {
                    return {
                        id: subRecipe.id,
                        title: subRecipe.title,
                        ingredients: subRecipe.ingredients,
                        needToBuys: subRecipe.listable_ingredients,
                        directions: subRecipe.directions,
                        notes: subRecipe.notes,
                    }
                });
            },

            addLinkedToChecked() {
                let checked = [];
                for (let recipe of this.linkedRecipes) {
                    checked.push(recipe.id);
                }
                return checked;
            },

            searchRecipes(item) {
                Recipes.search(item).then((response) => {
                    console.log(response);
                    this.recipes = response.data;
                });
            },

            clearSearch() {
                this.itemSearchedFor = '';
                Recipes.all().then((response) => {
                    this.recipes = response.data;
                });
            },

            saveLinkedRecipes() {
                this.recipesLinked = true;
                this.addRecipesOpen = false;
                this.linkedRecipes = this.checkedRecipes.map((recipeId) => {
                    return this.recipeMap[recipeId];
                });

                this.saveRecipe();
            },

            removeLinkedRecipe(id) {
                this.checkedRecipes.splice(this.checkedRecipes.indexOf(id), 1);
                this.linkedRecipes = this.checkedRecipes.map((recipeId) => {
                    return this.recipeMap[recipeId];
                });

                this.saveRecipe();
            }
        }
    }

</script>
