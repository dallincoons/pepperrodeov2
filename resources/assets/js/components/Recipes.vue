<template>
    <div class="container">
        <div class="container-heading"><h2>My Recipes</h2></div>
        <div class="button-wrapper">
            <router-link class="sq-button" to="/recipe/create"><add-icon-dark class="button-icon"></add-icon-dark> Add Recipe</router-link>
            <button class="sq-button" @click="newListModal"><add-to-list class="button-icon"></add-to-list> Add to List</button>
            <button class="sq-button" @click="toggleSearch"><search class="button-icon"></search>Search</button>
        </div>

        <div class="drop-wrapper" id="searchBox">
            <caret class="drop-caret"></caret>
            <input type="text" class="drop-input"><button class="drop-button">Search</button>
            <div class="radio-wrapper">
                <span><input type="radio" value="Alphabetical"> Alphabetical</span>
                <span><input type="radio" value="Recently Added"> Recently Added</span>
            </div>
        </div>

        <div class="container-body recipes-wrapper " id="recipes-container">
            <div v-for="(recipeGroup, categoryName) in groupedRecipes" class="category-container">
                <h3 class="dept_heading">{{categoryName}}</h3>
                <ul class="recipes-list">
                    <li class="recipe-ingredient" v-for="recipe in recipeGroup">
                        <router-link :to="{ name: 'recipe', params: { id: recipe.id }}">{{recipe.title}}</router-link>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</template>

<script>
    import Recipes from './resources/Recipes.js';
    import _ from 'lodash';
    import AddIconDark from './assets/add-icon-dark.vue';
    import Search from './assets/search.vue';
    import AddToList from './assets/add-to-list.vue';

    export default {
        components : {
            AddIconDark,
            Search,
            AddToList
        },

        data() {
            return {
                recipes : [],
                searchOpen : false,
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
                let recipesContainer = document.getElementById("recipes-container");
                let searchBox = document.getElementById("searchBox");
                if(this.searchOpen === false) {
                    this.searchOpen = true;
                    recipesContainer.classList.add("margin-transition");
                    searchBox.classList.add("show-box");
                } else {
                    this.searchOpen = false;
                    recipesContainer.classList.remove("margin-transition");
                    searchBox.classList.remove("show-box");
                }

            },
        }

    }
</script>
