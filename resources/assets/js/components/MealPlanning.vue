<template>
    <div class="recipe-wrapper container">
        <div class="recipe-section">
            <div class="planning-heading">
                <div class="red-accent-bar"></div>
                <div class="planning-info">
                    <p class="section-title">Meal Planning</p>
                    <div>
                        <p class="section-title">Pick Your Dates</p>
                        <input type="date" id="start" name="plan-start" v-model="dateStart" :min="startMin">
                        <input type="date" id="end" name="plan-end" v-model="dateEnd" :min="endMin" :max="endMax">
                       <button @click="setDates">Start Planning</button>
                    </div>
                </div>
            </div>
            <div class="meal-planning-wrapper">
                <div class="dates-wrapper">
                    <div class="date-wrapper" v-for="(recipes, date) in scheduledRecipes">
                        <div class="date-heading">
                            <p>{{prettyDate(date)}}</p>
                        </div>
                        <div
                        class="section-for-recipes"
                        :id="date"
                        @drop='onDrop($event)'
                        @dragover.prevent
                        @dragenter.prevent
                        >
                            <div v-for="recipe in recipes">
                                {{recipe.title}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="planning-recipes-wrapper">
                    <div class="recipes-body">
                        <div class="container-body recipes-wrapper">
                            <div v-for="(recipeGroup, categoryName) in groupedRecipes" class="category-container">
                                <h3 class="dept_heading">{{categoryName}}</h3>
                                <ul class="recipes-list">
                                    <li class="recipe-ingredient" v-for="recipe in recipeGroup"  @dragstart='startDrag($event, recipe)'>
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
    import Recipes from './resources/Recipes';
    import moment from 'moment';

    export default {
        data() {
            return {
                recipes: [],
                listTitle : '',
                scheduledRecipes: {},
                dateStart : '',
                dateEnd: '',
                startMin: moment().format("YYYY-MM-DD"),
                endMax: moment().add(31, 'd').format("YYYY-MM-DD")
            }
        },
        computed : {
            groupedRecipes() {
                return _.groupBy(this.recipes, function (recipe) {
                    return recipe.category.title;
                });
            },
            endMin() {
                return this.dateStart;
            }
        },

        mounted() {
            Recipes.all().then((response) => {
                this.recipes = response.data;
            });
        },

        methods: {
            prettyDate: (date) => {
                return moment(date).format("YYYY")
            },

            startDrag: (evt, recipe) => {
                evt.dataTransfer.dropEffect = 'move';
                evt.dataTransfer.effectAllowed = 'move';
                evt.dataTransfer.setData('recipeID', recipe.id)
            },

            onDrop (evt) {
                const recipeID = evt.dataTransfer.getData('recipeID');
                let targetID = evt.target.id;
                const recipe = this.recipes.find(recipe => recipe.id == recipeID);
                this.scheduledRecipes[targetID].push(recipe)
            },

            setDates() {
                let amountOfDays = moment(this.dateEnd).diff(this.dateStart, 'days');
                let startDay = moment(this.dateStart);
                for (let i = 0; i < amountOfDays; i++) {
                    this.$set(this.scheduledRecipes, startDay.add(1, 'd').format("YYYY-MM-DD"), []);
                }
            }
        }
    }
</script>

<style scoped>
    .drop-zone {
        background-color: #eee;
        margin-bottom: 10px;
        padding: 10px;
    }

    .drag-el {
        background-color: #fff;
        margin-bottom: 10px;
        padding: 5px;
    }
    .recipe-section {
        background: #ffffff;
        margin: 1rem 4rem 2rem 4rem;
        padding-bottom: 10rem;
        display: block;
        grid-template-rows: none;
        grid-template-columns: none;
    }
</style>
