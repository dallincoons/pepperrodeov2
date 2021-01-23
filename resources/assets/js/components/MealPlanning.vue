<template>
    <div class="recipe-wrapper container">
        <div class="recipe-section">
            <div class="planning-heading">
                <div class="red-accent-bar"></div>
                <div class="planning-info">
                    <h3 class="meal-planning-title">Meal Planning</h3>
                    <div v-if="datesSet" class="planning-header-section">
                        <p class="planning-dates">{{prettyDate(dateStart)}} - {{prettyDate(dateEnd)}}</p>
                        <button class="planning-button" @click="saveMealPlan()">Save Plan</button>
                    </div>
                    <p class="section-title" v-if="!datesSet">First, which days are you planning meals for?</p>
                    <div class="pick-dates-wrapper" v-if="!datesSet">
                        <div class="date-form-section">
                            <label for="start">Start Date</label>
                            <input type="date" id="start" name="plan-start" v-model="dateStart" :min="startMin">
                        </div>
                        <span class="date-separator"> - </span>
                        <div class="date-form-section">
                            <label for="end">End Date</label>
                            <input type="date" id="end" name="plan-end" v-model="dateEnd" :min="endMin" :max="endMax">
                        </div>
                       <button @click="setDates" class="planning-button">Start Planning ></button>
                    </div>
                </div>
            </div>
            <div class="meal-planning-wrapper" v-if="datesSet">
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
                            <div v-for="recipe in recipes" class="recipe-on-date" :id="date">
                                <div class="recipe-on-date-info">
                                    <span class="date-category">{{recipe.category.title}}</span>
                                    <p class="date-recipe-title">{{recipe.title}}</p>
                                </div>
                                <span @click="removeRecipe(date, recipe.id)" class="remove-date-recipe">x</span>
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
                endMax: moment().add(31, 'd').format("YYYY-MM-DD"),
                datesSet: false
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
                return moment(date).format("dddd, MMMM Do")
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
                this.$set(this.scheduledRecipes, startDay.format("YYYY-MM-DD"), []);
                for (let i = 0; i < amountOfDays; i++) {
                    this.$set(this.scheduledRecipes, startDay.add(1, 'd').format("YYYY-MM-DD"), []);
                }
                this.datesSet = true;
            },

            removeRecipe(date, id) {
                let recipeToRemove = this.scheduledRecipes[date].findIndex(recipe => recipe.id === id);
                return this.scheduledRecipes[date].splice(recipeToRemove, 1)
            },

            saveMealPlan() {
                axios.post('/api/v1/meal_planning_groups', {scheduled_recipes : this.scheduledRecipes}).then((response) => {
                    console.log(response);
                    this.$router.push({ path: `/mealplan/${response.data.meal_planning_group.id}` });
                });
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
