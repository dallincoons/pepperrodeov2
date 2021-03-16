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
                    <div class="date-wrapper" v-for="(entries, date) in schedule">
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
                            <div v-for="entry in entries.recipes" class="recipe-on-date" :id="date" draggable="true" @dragstart='startDrag($event, entry)' data-on-list="recipe">
                                <div class="recipe-on-date-info" v-if="!editing"  :id="date">
                                    <span class="date-category" :id="date">{{entry.category.title}}</span>
                                    <p @drop='onDrop($event)' :id="date" class="date-recipe-title">{{entry.title}}</p>
                                </div>
                                <div class="recipe-on-date-info" v-if="editing" :id="date">
                                    <span class="date-category" :id="date">{{entry.category.title}}</span>
                                    <p class="date-recipe-title" @drop='onDrop($event)' :id="date">{{entry.title}}</p>
                                </div>

                                <span @click="removeEntry(date, entry)" class="remove-date-recipe">x</span>
                            </div>
                            <div v-for="entry in entries.items" class="recipe-on-date" :id="date" draggable="true" @dragstart='startItemDrag($event, entry)' data-on-list="recipe">
                                <div class="recipe-on-date-info" v-if="!editing"  :id="date">
                                    <p @drop='onDrop($event)' :id="date" class="date-recipe-title">{{entry.title}}</p>
                                </div>
                                <div class="recipe-on-date-info" v-if="editing" :id="date">
                                    <p class="date-recipe-title" @drop='onDrop($event)' :id="date">
                                        <span>{{entry.title}}</span>
                                        <span v-if="!entry.title">{{entry}}</span>
                                    </p>
                                </div>

                                <span @click="removeEntry(date, entry)" class="remove-date-recipe">x</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="planning-recipes-wrapper">
                    <div class="section-for-recipes">
                        <p class="planning-dates">Add an item</p>
                        <form class="add-item-form">
                            <input type="text" v-model="itemToAdd" class="add-item-input recipe-input search-box">
                            <button class="add-item-button" @click="addItem"><add-plus></add-plus></button>
                        </form>
                        <ul class="items-added recipes-list">
                            <li v-for="item in itemsAdded" @dragstart='startItemDrag($event, item)' class="recipe-ingredient item-added" draggable="true" data-on-list="item" data-side="right">{{item}}</li>
                        </ul>
                    </div>
                    <div class="search-wrapper meal-planning-search-wrapper">
                        <p class="planning-dates">Add a recipe</p>
                        <div class="meal-planning-search-input-wrapper">
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
    import {createMissingDays} from "./meal_plan_calculator";
    import AddPlus from './assets/add-plus'

    export default {
        components : {
            XIcon,
            Search,
            AddPlus
        },
        props : {
            editing: Boolean
        },
        data() {
            return {
                recipes: [],
                listTitle : '',
                dateStart : '',
                dateEnd: '',
                startMin: moment().format("YYYY-MM-DD"),
                endMax: moment().add(31, 'd').format("YYYY-MM-DD"),
                datesSet: false,
                itemSearchedFor: '',
                draggedFrom: '',
                itemToAdd: '',
                itemsAdded: [],
                schedule: {}
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
            },
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
                if(recipe === '') {
                    return
                }

                evt.dataTransfer.dropEffect = 'move';
                evt.dataTransfer.effectAllowed = 'move';
                evt.dataTransfer.setData('recipeID', recipe.id);
                evt.dataTransfer.setData('dateFrom', evt.srcElement.id)

            },
            startItemDrag(evt, item) {
                if(evt.srcElement.id !== '') {
                    this.draggedFrom = evt.srcElement.id;
                }
                if(item === '') {
                    return
                }
                evt.dataTransfer.dropEffect = 'move';
                evt.dataTransfer.effectAllowed = 'move';
                let side = evt.target.getAttribute("data-side");
                evt.dataTransfer.setData('itemTitle', item);
                evt.dataTransfer.setData('side', side);
                evt.dataTransfer.setData('dateFrom', evt.srcElement.id);
                evt.dataTransfer.setData('type', 'item');

            },
            onDrop (evt) {
                if(evt.dataTransfer.getData('type') === 'item') {
                    const itemTitle = evt.dataTransfer.getData('itemTitle');
                    const side = evt.dataTransfer.getData('side');
                    const dateFrom = evt.dataTransfer.getData('dateFrom');
                    let targetID = evt.target.id;
                    let day = this.schedule[targetID];
                    day.items.push(itemTitle);
                    this.$set(this.schedule, targetID, day);
                    evt.stopPropagation();
                    if(dateFrom !== '') {
                        this.removeEntry(dateFrom, itemTitle);
                    }
                    if(side === "right") {
                        let itemToRemove = this.itemsAdded.findIndex(item => item === itemTitle);
                        return this.itemsAdded.splice(itemToRemove, 1);
                    }
                    return;
                }
                const recipeID = evt.dataTransfer.getData('recipeID');
                const dateFrom = evt.dataTransfer.getData('dateFrom');
                if(recipeID === '') {
                    return
                }
                let targetID = evt.target.id;
                evt.stopPropagation();
                const recipe = this.recipes.find(recipe => recipe.id == recipeID);
                let day = this.schedule[targetID];
                day.recipes.push(recipe);
                this.$set(this.schedule, targetID, day);
                if(dateFrom !== '') {
                    this.removeEntry(dateFrom, recipe.id);
                }
            },

            setDates() {
                let amountOfDays = moment(this.dateEnd).diff(this.dateStart, 'days');
                let startDay = moment(this.dateStart);
                this.$set(this.schedule, startDay.format("YYYY-MM-DD"), {items: [], recipes: []});
                for (let i = 0; i < amountOfDays; i++) {
                    let nextDay = startDay.add(1, 'd');
                    this.$set(this.schedule, nextDay.format("YYYY-MM-DD"), {items: [], recipes: []});
                }
                this.datesSet = true;
            },

            removeEntry(date, entry) {
                if(entry.recipe) {
                    let recipeToRemove = this.schedule[date].recipes.findIndex(recipe => recipe.id === entry.id);
                    return this.schedule[date].recipes.splice(recipeToRemove, 1)
                } else {
                    let itemToRemove = this.schedule[date].items.findIndex(item => item === entry.id);
                    return this.schedule[date].items.splice(itemToRemove, 1)
                }

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
                if (!this.editing) {
                    axios.post('/api/v1/meal_planning_groups', {schedule: this.schedule}).then((response) => {
                        this.$router.push({path: `/mealplan/${response.data.meal_planning_group.id}`});
                    });
                } else {
                    axios.patch('/api/v1/meal_planning_group/' + this.$route.params.id, {scheduled_recipes: this.scheduledRecipes}).then((response) => {
                        this.$router.push({path: `/mealplan/${response.data.meal_planning_group.id}`});
                    });
                }
            },
            populatePlanFields(id) {
                axios.get('api/v1/meal_planning_group/' + id).then((response) => {
                    let startDate = moment(response.data.start_date);
                    let endDate = moment(response.data.end_date);
                    this.dateStart = startDate;
                    this.dateEnd = endDate;
                    this.datesSet = true;
                    let days = createMissingDays(response.data.schedule, this.dateStart, this.dateEnd);
                    this.schedule = days;
                    this.getScheduledRecipes(days);
                });
            },

            getScheduledRecipes(days) {
                let result = {};
                for (const [date, mealPlanDay] of Object.entries(days)) {
                    let recipes = [];
                    result[date] = recipes;

                    for (const day of mealPlanDay) {
                        recipes.push(day.recipe);
                    }
                }
                this.schedule = result;
            },

            addItem() {
                this.itemsAdded.push(this.itemToAdd);
                this.itemToAdd = '';
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
