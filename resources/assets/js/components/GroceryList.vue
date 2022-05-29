<template>
    <div class="container">
        <edit-item-modal
        v-if="showModal"
        :itemToUpdate="itemToUpdate"
        :departments="departments"
        @close="hideModal"
        @update="updateItem"
        @delete="deleteItem"
        ></edit-item-modal>
        <div class="list-container">
            <div class="list-wrapper">
                <div class="red-accent-bar"></div>
                <div class="list-heading">
                    <h3 class="list-title">{{list.title}}</h3>
                    <div class="list-actions-wrapper">
                        <div class="list-actions-buttons">
                            <button class="list-action list-action-1" @click="toggleAddItems" :class="{'list-selected-action' : dropOpen}">Add Item</button>
                            <button class="list-action list-action-2" @click="viewRecipes(); toggleViewListRecipes();" :class="{'list-selected-action' : addRecipesOpen}">Add Recipe(s)</button>
                            <button class="list-action list-action-3" @click="print()">Print List</button>
                            <button class="list-action list-action-4" @click="deleteList">Delete List</button>
                        </div>
                        <div class="open-action-wrapper" :class="{'action-open' : addRecipesOpen, 'action-open' : dropOpen}">
                            <div class="list-drop-wrapper" :class="{'list-show-box' : dropOpen}">
                                <new-item-form @updated="getList" :departments="departments"></new-item-form>
                            </div>
                            <div class="list-add-recipes-wrapper" :class="{'list-show-recipes' : addRecipesOpen}">
                                <div class="list-add-recipes-body">
                                    <div class="list-add-recipes-recipes-section">
                                        <div class="list-add-recipes-header">
                                            <h4 class="list-add-recipes-heading">Recipes</h4>
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
                                            </div>
                                        </div>
                                        <div v-for="(recipeGroup, categoryName) in groupedRecipes" class="category-container">
                                            <h3 class="small_dept_heading">{{categoryName}}</h3>
                                            <ul class="list-add-recipes-list">
                                                <li v-for="recipe in recipeGroup" class="list-add-recipes-item">
                                                    <div class="fs-checkbox">
                                                        <input type="checkbox" :id="'checkbox_' + recipe.id" :value="recipe.id" v-model="checkedRecipes">
                                                        <label :for="'checkbox_' + recipe.id">{{recipe.title}}</label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="selected-added-wrapper">
                                        <div class="selected-recipes-wrapper">
                                            <h4 class="list-add-recipes-heading">Recipes Selected</h4>
                                            <div class="selected-recipes-list">
                                            <p v-if="Object.keys(recipesAdded).length === 0" class="no-recipe-message">No Recipes Selected Yet!</p>
                                                <div v-for="(recipeGroup, categoryName) in recipesAdded" class="category-container-add-list">
                                                    <h3 class="small_dept_heading">{{categoryName}}</h3>
                                                        <ul>
                                                            <li v-for="recipe in recipeGroup">{{recipe.title}}</li>
                                                        </ul>
                                                </div>
                                                <button @click="addRecipesToList" class="list-add-recipes-button">Add Recipe(s)</button>
                                            </div>
                                        </div>
                                        <div class="added-recipes-wrapper" v-if="list.recipes">
                                            <recipes-on-list
                                                    v-if="viewListRecipes"
                                                    :recipes="list.recipes"
                                                    :list="list"
                                                    @close="viewListRecipes = !viewListRecipes"
                                                    @deleted="recipeDeleted"
                                            >
                                            </recipes-on-list>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p v-if="list.recipes && list.recipes.length === 0" class="nothing-on-list">Nothing on your list yet, click 'add an item' or 'add recipe(s)' to get started!</p>
                <div class="list-body">
                    <div class="list-depts-wrapper">
                        <div class="department-container" v-for="(items, department_name) in itemsGrouped"><div class="dept_heading"><span class="red-accent-line"></span>{{department_name}}</div>
                    <ul class="list-items">
                        <li v-for="item in items" class="list-item" @dblclick="openEditItem(item)">
                            <span @click="toggleItem(item)" class="list-checkbox"><span v-bind:class="{checkmark : checkedItems.includes(item.id)}"></span></span>
                            <span class="item" v-bind:class="{checked : checkedItems.includes(item.id)}">{{showItemDescription(item.quantity, item.description)}}</span>
                        </li>

                    </ul>
                </div>
                    </div>
                    <div class="main-added-recipes-wrapper" v-bind:class="{'notSticky' : showModal}">
                        <recipes-on-list
                                v-if="list.recipes && list.recipes.length > 0"
                                :recipes="list.recipes"
                                :list="list"
                                @deleted="recipeDeleted"
                        >
                        </recipes-on-list>
                    </div>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
    import GroceryLists from './resources/GroceryLists';
    import EditItemModal from './GroceryList/EditItemModal.vue';
    import NewItemForm from './GroceryList/NewItemForm.vue';
    import Caret from './assets/caret.vue';
    import FullScreenModal from './FullScreenModal.vue';
    import Modal from './Modal.vue';
    import RecipesOnList from './RecipesOnList';
    import Trashcan from "./assets/trashcan";
    import Recipes from "./resources/Recipes";
    import Search from "./assets/search"
    import XIcon from "./assets/x-icon"

    export default {

        components : {
            Trashcan,
            EditItemModal,
            NewItemForm,
            Caret,
            FullScreenModal,
            Modal,
            RecipesOnList,
            Search,
            XIcon
        },

        data(){
            return {
                showModal: false,
                list: {},
                listId: '',
                description: '',
                departments: '',
                itemToUpdate: '',
                editable: false,
                recipes: [],
                checkedRecipes: [],
                checkedItems: [],
                dropOpen: false,
                addRecipesModalShown: false,
                optionModal: false,
                viewListRecipes: false,
                addRecipesOpen: false,
                itemSearchedFor: '',
                recipeMap: {},
            }
        },

        computed : {
            itemsGrouped: function () {
                return _.chain(this.list.combinedItems)
                    .sortBy(function (item) {
                        return item.department;
                    })
                    .groupBy(function (item) {
                        return item.department;
                    }).value();
            },

            recipesAdded: function () {

                let checkedRecipes = this.checkedRecipes.map((recipeId) => {
                    return this.recipeMap[recipeId];
                });

               return _.groupBy(checkedRecipes, function (recipe) {
                    return recipe.category.title;
                });
            },

            recipesOnList: function () {
                return this.list.recipes
            },
            groupedRecipes() {
                return _.groupBy(this.recipes, function (recipe) {
                    return recipe.category.title;
                });
            }
        },

        mounted() {
            this.listId = this.$route.params.id;
            this.getList();
            this.getDepartments();
            this.getRecipes((recipes) => {
                recipes.forEach((recipe) => {
                    this.recipeMap[recipe.id] = recipe;
                });
            });
        },

        methods    : {
            hideModal() {
                this.showModal = false;
            },

            displayModal() {
                this.showModal = true;
            },

            showItemDescription(quantity, description) {
                if (quantity < 2) {
                    return description;
                }

                return `${quantity} ${description}`
            },

            getList() {
                axios.get('/api/v1/grocery-lists/' + this.listId).then((response) => {
                    this.list = response.data;
                });
            },

            getDepartments() {
                axios.get('/api/v1/departments').then((response) => {
                    this.departments = response.data;
                });
            },

            getRecipes(then) {
                axios.get('/api/v1/recipes').then((response) => {
                    this.recipes = response.data;
                    then(this.recipes);
                });
            },

            toggleItem(item) {
                if (this.checkedItems.includes(item.id)) {
                    this.checkedItems.splice(this.checkedItems.indexOf(item.id), 1)
                } else {
                    this.checkedItems.push(item.id)
                }
            },

            updateItem(itemToUpdate) {
                this.hideModal();
                axios.patch('/api/v1/grocery-list-item', {
                    grocery_list_id : parseInt(this.listId),
                    new_description : itemToUpdate.new_description,
                    description : itemToUpdate.description,
                    department_id : itemToUpdate.department_id,
                }).then((response) => {
                    this.getList();
                });
            },

            openEditItem(item) {
                this.itemToUpdate = item;
                this.displayModal();
            },

            recipeDeleted() {
                this.getList();
            },

            deleteItem(itemToUpdate) {
                this.hideModal();
                let requests = [];
                itemToUpdate.ids.forEach((id) => {
                    requests.push(axios.delete('/api/v1/grocery-list-item/' + id));
                });
                axios.all(requests).then(response => {
                    this.getList();
                });
            },

            updateListTitle() {
                axios.patch('/api/v1/grocery-lists/' + this.listId, {
                    title       : this.list.title,
                }).then((response) => {
                    this.getList();
                    this.editable = false;
                });
            },

            viewRecipes() {
                this.addRecipesOpen = !this.addRecipesOpen;
            },

            addRecipesToList() {
                GroceryLists.addRecipes(this.listId, this.checkedRecipes).then((response) => {
                    this.addRecipesModalShown = false;
                    this.getList();
                    this.checkedRecipes = [];
                    if (response.status == 200) {
                        this.list.recipes = this.list.recipes.concat(response.data.recipes_added)
                        vm.$set('list.recipes', this.list.recipes)
                    }
                });
            },

            toggleAddItems() {
                this.dropOpen = !this.dropOpen;
                if(this.addRecipesOpen === true){
                    this.addRecipesOpen = false;
                }
            },

            toggleOptions() {
                this.optionModal = !this.optionModal;
            },

            toggleViewListRecipes() {
                this.toggleOptions();
                this.viewListRecipes = !this.viewListRecipes;
                if(this.dropOpen === true){
                    this.dropOpen = false;
                }
            },

            deleteList() {
                if(confirm('Do you want to delete this list?')) {

                    GroceryLists.delete(this.listId).then(response => {
                        this.optionModal = !this.optionModal;
                        this.$router.push({path : `/grocery-lists`});
                    });

                }
            },
            deleteRecipe(recipeId) {
                let deleteConfirm = confirm("Are you sure you want to delete this recipe?" );
                if (deleteConfirm === false) {
                    return;
                }

                Recipes.delete(recipeId).then(response => {
                    alert("deleted!");
                    if (response.status === 200) {
                        this.viewRecipes();
                        this.addRecipesToList();
                    }
                })
            },
            print() {
                window.print();
            },
            searchRecipes(item) {
                Recipes.search(item).then((response) => {
                    this.recipes =  response.data;
                });
            },
            clearSearch() {
                this.itemSearchedFor = '';
                Recipes.all().then((response) => {
                    this.recipes = response.data;
                });
            },
        }
    }
</script>
