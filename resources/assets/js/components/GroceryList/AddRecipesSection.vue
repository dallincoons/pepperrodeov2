<template>
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
        <ul class="list-add-recipes-list">
            <li v-for="recipe in recipes" class="list-add-recipes-item">
                <div class="fs-checkbox">
                    <input type="checkbox" :id="'checkbox_' + recipe.id" :value="recipe.id" v-model="store.checkedRecipes">
                    <label :for="'checkbox_' + recipe.id">{{recipe.title}}</label>
                </div>
            </li>
        </ul>
    </div>
</template>

<script setup>
import {useListAddRecipesStore} from "./AddRecipesStore";

const store = useListAddRecipesStore();
</script>

<script>
    import Recipes from "../resources/Recipes";
    import XIcon from "../assets/x-icon";
    import Search from "../assets/search"
    export default {
        props: {
            modalClass : {
                type: String,
                default: 'ol-modal-container'
            }
        },

        components : {
            XIcon,
            Search,
        },

        mounted() {
            this.getRecipes();
        },

        data() {
            return {
                itemSearchedFor: '',
                recipes: [],
            }
        },

        methods: {
            getRecipes(then) {
                axios.get('/api/v1/recipes').then((response) => {
                    this.recipes = response.data;
                    then(this.recipes);
                });
            },
        },

        clearSearch() {
            this.itemSearchedFor = '';
            Recipes.all().then((response) => {
                this.recipes = response.data;
            });
        },

        searchRecipes(item) {
            Recipes.search(item).then((response) => {
                this.recipes =  response.data;
            });
        },
    }
</script>
