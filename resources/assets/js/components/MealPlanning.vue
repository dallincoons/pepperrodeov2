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
                    <div class="date-wrapper" v-for="(entries, date) in groupRecipesAndItems">
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
                            <div v-for="entry in entries" class="recipe-on-date" :id="date" draggable="true" @dragstart='startDrag($event, entry)' data-on-list="recipe">
                                <div class="recipe-on-date-info" v-if="!editing"  :id="date">
                                    <span class="date-category" :id="date">{{entry.category}}</span>
                                    <p @drop='onDrop($event)' :id="date" class="date-recipe-title">{{entry.title}}</p>
                                </div>
                                <div class="recipe-on-date-info" v-if="editing">
                                    <span class="date-category">{{entry.category}}</span>
                                    <p class="date-recipe-title">{{entry.title}}</p>
                                </div>
                                <!--<span @click="removeRecipe(date, recipe.id)" class="remove-date-recipe">x</span>-->
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
                            <li v-for="item in itemsAdded" @dragstart='startItemDrag($event, item)' class="recipe-ingredient item-added" draggable="true" data-on-list="item">{{item}}</li>
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
                scheduledRecipes: {},
                dateStart : '',
                dateEnd: '',
                startMin: moment().format("YYYY-MM-DD"),
                endMax: moment().add(31, 'd').format("YYYY-MM-DD"),
                datesSet: false,
                itemSearchedFor: '',
                draggedFrom: '',
                itemToAdd: '',
                itemsAdded: [],
                scheduledItems: {}
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
            groupRecipesAndItems() {
                const thingsOnDay = {};
                const days = Object.keys(this.scheduledRecipes);
                for (const day of days) {
                    thingsOnDay[day] = [];
                }
                let startDay = moment(this.dateStart);
                let amountOfDays = moment(this.dateEnd).diff(this.dateStart, 'days');
                this.$set(thingsOnDay, startDay.format("YYYY-MM-DD"), []);
                for (let i = 0; i < amountOfDays; i++) {
                    this.$set(thingsOnDay, startDay.add(1, 'd').format("YYYY-MM-DD"), []);
                }
                // for (const [key, value] of Object.entries(this.scheduledItems)) {
                //     console.log(`${key}: ${value}`);
                //     console.log(thingsOnDay[key]);
                // for (const item in this.scheduledItems) {
                    // console.log(`${item}: ${this.scheduledItems[item]}`);
                    // console.log(thingsOnDay[item]);
                    // thingsOnDay[item].push({
                    //     title: this.scheduledItems[item],
                    //     category: 'item',
                    //     type: 'item'
                    // });
                // }
                // this.scheduledItems.forEach((item) => {
                //     thingsOnDay.push({
                //         title: item,
                //         category: 'item',
                //         type: 'item'
                //     });
                // });

                // this.scheduledRecipes.forEach((recipe) => {
                //     thingsOnDay.push({
                //         title: recipe.title,
                //         category: recipe.category.title,
                //         type: 'recipe'
                //     });
                // });

                return thingsOnDay;
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
                if(recipe === '') {
                    return
                }

                evt.dataTransfer.dropEffect = 'move';
                evt.dataTransfer.effectAllowed = 'move';
                evt.dataTransfer.setData('recipeID', recipe.id);

            },
            onDrop (evt) {
                if(evt.dataTransfer.getData('recipeID') === '') {
                    const item = evt.dataTransfer.getData('item');
                    let targetID = evt.target.id;
                    evt.stopPropagation();
                    this.scheduledItems[targetID].push(item);
                    return;
                }
                const recipeID = evt.dataTransfer.getData('recipeID');
                if(recipeID === '') {
                    return
                }
                let targetID = evt.target.id;
                evt.stopPropagation();
                const recipe = this.recipes.find(recipe => recipe.id == recipeID);
                this.scheduledRecipes[targetID].push(recipe);
                if(this.draggedFrom !== '') {
                    this.removeRecipe(this.draggedFrom, recipe.id);
                    this.draggedFrom = '';
                }
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
                evt.dataTransfer.setData('item', item);

            },

            setDates() {
                let amountOfDays = moment(this.dateEnd).diff(this.dateStart, 'days');
                let startDay = moment(this.dateStart);
                this.$set(this.scheduledRecipes, startDay.format("YYYY-MM-DD"), []);
                this.$set(this.scheduledItems, startDay.format("YYYY-MM-DD"), []);
                for (let i = 0; i < amountOfDays; i++) {
                    let nextDay = startDay.add(1, 'd');
                    this.$set(this.scheduledRecipes, nextDay.format("YYYY-MM-DD"), []);
                    this.$set(this.scheduledItems, nextDay.format("YYYY-MM-DD"), []);
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
