<template>
    <div class="container recipes-main-wrapper">
        <div class="recipes-secondary-wrapper">
        <div class="recipes-heading"><h3>My Recipes</h3></div>
        <div class="recipes-button-wrapper">
            <router-link class="recipes-action" to="/recipe/create">Create New Recipe</router-link>
            <div class="search-wrapper">
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
            <div>

            </div>
        <div class="recipes-body">
            <div class="container-body recipes-wrapper" :class="{'margin-transition' : searchOpen}">
                <!--<div v-for="recipe in recipes" class="category-container" v-show="!searchResults">-->
                    <ul class="recipes-list">
                        <li class="recipe-ingredient" v-for="recipe in recipes">
                            <input type="checkbox" v-if="showLists" :value="recipe.id" v-model="checkedRecipes">
                            <router-link :to="{ name: 'recipe', params: { id: recipe.id }}">{{recipe.title}}</router-link>
                        </li>
                    </ul>
                <!--</div>-->
                <div v-show="searchResults">
                    {{searchResults}}
                </div>
            </div>
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
    import RecipesOnList from './RecipesOnList'
    import XIcon from './assets/x-icon'

    export default {
        components : {
            AddIconDark,
            Search,
            AddToList,
            Caret,
            Modal,
            RecipesOnList,
            XIcon
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
                listTitle : '',
                itemSearchedFor : '',
                searchResults : '',
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
