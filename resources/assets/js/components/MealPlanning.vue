<template>
    <div class="recipe-wrapper container">
        <div class="recipe-section meal-planning-section">
            <div class="planning-heading">
            <h3 v-if="editing">Editing</h3>
                <div class="red-accent-bar"></div>
                <div class="planning-info">
                    <h3 class="meal-planning-title">Meal Planning</h3>
                    <div v-if="datesSet" class="planning-header-section">
                        <p class="planning-dates">{{prettyDate(dateStart)}} - {{prettyDate(dateEnd)}}</p>
                        <button class="planning-button" @click="saveMealPlan()">Save Plan</button>
                    </div>
                    <p class="section-title" v-if="!datesSet" v-show="!editing">First, which days are you planning meals for?</p>
                    <div class="pick-dates-wrapper" v-if="!datesSet" v-show="!editing">
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
                            <div v-for="recipe in recipes" class="recipe-on-date" :id="date" draggable="true" @dragstart='startDrag($event, recipe)'>
                                <div class="recipe-on-date-info" v-if="!editing">
                                    <span class="date-category">{{recipe.category.title}}</span>
                                    <p @drop='onDrop($event)' :id="date" class="date-recipe-title">{{recipe.title}}</p>
                                </div>
                                <div class="recipe-on-date-info" v-if="editing">
                                    <span class="date-category">{{recipe.category.title}}</span>
                                    <p class="date-recipe-title">{{recipe.title}}</p>
                                </div>
                                <span @click="removeRecipe(date, recipe.id)" class="remove-date-recipe">x</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="planning-recipes-wrapper">
                    <div class="search-wrapper meal-planning-search-wrapper">
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
    import XIcon from './assets/x-icon';
    import Search from './assets/search.vue';

    export default {
        components : {
            XIcon,
            Search
        },
        props : {
            editing: Boolean
        },
        data() {
            return {
                recipes: [],
                listTitle : '',
                scheduledRecipes: {},
                dateStart : '',
                dateEnd: '',
                startMin: moment().format("YYYY-MM-DD"),
                endMax: moment().add(31, 'd').format("YYYY-MM-DD"),
                datesSet: false,
                itemSearchedFor: '',
                draggedFrom: ''
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
            if (this.editing) {
                this.populatePlanFields(this.$route.params.id)
            }
        },

        methods: {
            prettyDate: (date) => {
                return moment(date).format("dddd, MMMM Do")
            },

            startDrag(evt, recipe) {
                if(evt.srcElement.id !== '') {
                    this.draggedFrom = evt.srcElement.id;
                }

                evt.dataTransfer.dropEffect = 'move';
                evt.dataTransfer.effectAllowed = 'move';
                evt.dataTransfer.setData('recipeID', recipe.id);

            },

            onDrop (evt) {
                const recipeID = evt.dataTransfer.getData('recipeID');
                let targetID = evt.target.id;
                const recipe = this.recipes.find(recipe => recipe.id == recipeID);
                this.scheduledRecipes[targetID].push(recipe);
                if(this.draggedFrom !== '') {
                    this.removeRecipe(this.draggedFrom, recipe.id);
                    this.draggedFrom = '';
                }
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

            saveMealPlan() {
                axios.post('/api/v1/meal_planning_groups', {scheduled_recipes : this.scheduledRecipes}).then((response) => {
                    this.$router.push({ path: `/mealplan/${response.data.meal_planning_group.id}` });
                });
            },
            populatePlanFields(id) {
                axios.get('api/v1/meal_planning_group/' + id).then((response) => {
                    this.dateStart = Object.keys(response.data.days)[0];
                    this.dateEnd = Object.keys(response.data.days).slice(-1)[0];
                    this.datesSet = true;
                    this.scheduledRecipes = response.data.days;
                    this.getScheduledRecipes();
                });


            },
            getScheduledRecipes() {
                let result = {};
                for (const [date, mealPlanDay] of Object.entries(this.scheduledRecipes)) {
                    let recipes = [];
                    for (const day of mealPlanDay) {
                        recipes.push(day.recipe);
                        result[date] = recipes;
                    }
                }
                this.scheduledRecipes = result;
            }
        }
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
