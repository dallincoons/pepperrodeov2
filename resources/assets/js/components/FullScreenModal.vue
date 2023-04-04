<template>
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
</template>

<script>
    export default {

        props: {
            modalClass : {
                type: String,
                default: 'ol-modal-container'
            }
        },
        mounted() {
            setInterval(() => {  this.transitionClass = 'transition-fs'; }, 100);

        },

        data() {
            return {
                transitionClass : ' '
            }
        },

        methods : {
            close(){
                this.$emit('close');
            },


        }
    }
</script>

