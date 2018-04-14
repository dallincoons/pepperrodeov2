<template>
    <div class="container">
        <div class="container-heading"><h2>My Recipes</h2></div>
        <div class="button-wrapper">
            <router-link class="sq-button" to="/recipe/create"><add-icon-dark class="button-icon"></add-icon-dark> Add Recipe</router-link>
            <button class="sq-button" @click="toggleShowLists"><add-to-list class="button-icon"></add-to-list> Add to List</button>
            <button class="sq-button" @click="toggleSearch"><search class="button-icon"></search>Search</button>
        </div>

        <div v-if="showLists">
            <select v-model="selectedList">
                <option v-for="list in lists" :value="list.id"> {{list.title}}</option>
            </select>
            <button @click="addRecipesToList">Add to List</button><button @click="toggleNewList">New List</button>
            <modal
                    v-if="newGroceryListModalShown"
                    @close="newGroceryListModalShown = !newGroceryListModalShown"
            >
                <span slot="close" class="modal-close">X</span>
                <h4 class="modal-heading">Add New List</h4>
                <div class="container-create">
                    <form v-on:submit.prevent class="create-form">
                        <input title="Grocery List Title" v-model="listTitle" @keyup.enter="saveList()" class="title-input" placeholder="List Title">
                        <button type="button" @click="saveList()" class="dk-modal-button">Save</button>
                    </form>
                </div>
            </modal>
        </div>

        <div class="drop-wrapper" :class="{'show-box' : searchOpen}">
            <caret class="drop-caret"></caret>
            <input type="text" class="drop-input"><button class="drop-button">Search</button>
            <div class="radio-wrapper">
                <span><input type="radio" value="Alphabetical"> Alphabetical</span>
                <span><input type="radio" value="Recently Added"> Recently Added</span>
            </div>
        </div>

        <div class="container-body recipes-wrapper" :class="{'margin-transition' : searchOpen}">
            <div v-for="(recipeGroup, categoryName) in groupedRecipes" class="category-container">
                <h3 class="dept_heading">{{categoryName}}</h3>
                <ul class="recipes-list">
                    <li class="recipe-ingredient" v-for="recipe in recipeGroup">
                        <input type="checkbox" v-if="showLists" :value="recipe.id" v-model="checkedRecipes">
                        <router-link :to="{ name: 'recipe', params: { id: recipe.id }}">{{recipe.title}}</router-link>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</template>

<script>
    import Recipes from './resources/Recipes';
    import GroceryLists from './resources/GroceryLists';
    import _ from 'lodash';
    import AddIconDark from './assets/add-icon-dark.vue';
    import Search from './assets/search.vue';
    import AddToList from './assets/add-to-list.vue';
    import Caret from './assets/caret.vue';
    import Modal from './Modal.vue'

    export default {
        components : {
            AddIconDark,
            Search,
            AddToList,
            Caret,
            Modal
        },

        data() {
            return {
                recipes: [],
                searchOpen: false,
                showLists: false,
                lists: [],
                selectedList : '',
                checkedRecipes: [],
                newGroceryListModalShown : false,
                listTitle : ''
            }
        },

        computed : {
            groupedRecipes() {
                return _.groupBy(this.recipes, 'category.title');
            }
        },

        mounted() {
            Recipes.all().then((response) => {
                this.recipes = response.data;
            });

        },

        methods : {
            toggleSearch() {
                this.searchOpen = !this.searchOpen;
            },

            toggleShowLists() {
                this.showLists = !this.showLists;
                this.getLists();
            },

            getLists() {
                GroceryLists.get().then((response) => {
                    this.lists = response.data.data;
                });
            },

            addRecipesToList() {
                GroceryLists.addRecipes(this.selectedList, this.checkedRecipes).then((response) => {
                    this.checkedRecipes = [];
                    this.showLists = false;
                });
            },

            toggleNewList() {
                this.newGroceryListModalShown = !this.newGroceryListModalShown;
            },

            saveList() {
                this.toggleNewList();
                GroceryLists.save(this.listTitle).then((response) => {
                    this.getLists();
                    this.selectedList = response.data.data.id;
                });
            }
        }

    }
</script>
