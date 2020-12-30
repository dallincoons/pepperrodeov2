<template>
    <div class="recipe-wrapper container">
        <div class="recipe-section">
            <div class="planning-heading">
                <div class="red-accent-bar"></div>
                <div class="planning-info">
                    <p class="section-title">Meal Planning</p>
                    <h3 class="list-title">November 8 - November 14</h3>
                </div>
            </div>
            <div class="meal-planning-wrapper">
                <div class="dates-wrapper">
                    <div class="date-wrapper">
                        <div class="date-heading">
                            <p>Sunday, November 8th, 2020</p>
                        </div>
                        <div class="section-for-recipes"></div>
                    </div>
                    <div class="date-wrapper">
                        <div class="date-heading">
                            <p>Monday, November 9th, 2020</p>
                        </div>
                        <div class="section-for-recipes"></div>
                    </div>
                    <div class="date-wrapper">
                        <div class="date-heading">
                            <p>Tuesday, November 10th, 2020</p>
                        </div>
                        <div class="section-for-recipes"></div>
                    </div>
                    <div class="date-wrapper">
                        <div class="date-heading">
                            <p>Wednesday, November 11th, 2020</p>
                        </div>
                        <div class="section-for-recipes"></div>
                    </div>
                    <div class="date-wrapper">
                        <div class="date-heading">
                            <p>Thursday, November 12th, 2020</p>
                        </div>
                        <div class="section-for-recipes"></div>
                    </div>
                    <div class="date-wrapper">
                        <div class="date-heading">
                            <p>Friday, November 13th, 2020</p>
                        </div>
                        <div class="section-for-recipes"></div>
                    </div>
                    <div class="date-wrapper">
                        <div class="date-heading">
                            <p>Saturday, November 14th, 2020</p>
                        </div>
                        <div class="section-for-recipes"></div>
                    </div>
                </div>
                <div class="planning-recipes-wrapper">
                    <div class="recipes-body">
                        <div class="container-body recipes-wrapper">
                            <div v-for="(recipeGroup, categoryName) in groupedRecipes" class="category-container">
                                <h3 class="dept_heading">{{categoryName}}</h3>
                                <ul class="recipes-list">
                                    <li class="recipe-ingredient" v-for="recipe in recipeGroup">
                                        <!--<input type="checkbox" v-if="showLists" :value="recipe.id" v-model="checkedRecipes">-->
                                        <router-link :to="{ name: 'recipe', params: { id: recipe.id }}">{{recipe.title}}</router-link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                recipes: [],
            }
        },
        computed : {
            groupedRecipes() {
                return _.groupBy(this.recipes, 'category.title');
            }
        },

        mounted() {
            Recipes.all().then((response) => {
                console.log(response);
                this.recipes = response.data;
            });

        },

        methods: {}
    }
</script>

<style scoped>
    .recipe-section {
        background: #ffffff;
        margin: 1rem 4rem 2rem 4rem;
        padding-bottom: 10rem;
        display: block;
        grid-template-rows: none;
        grid-template-columns: none;
    }
</style>
