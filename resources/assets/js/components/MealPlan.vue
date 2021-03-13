<template>
    <div class="container lists-main-wrapper">
        <div class="list-container">
            <div class="list-wrapper">
                <div class="red-accent-bar"></div>
                <div class="list-heading">
                    <h3 class="list-title">Meal Plan for {{startDay}} - {{endDay}}</h3>
                    <div class="list-actions-wrapper">
                        <div class="list-actions-buttons meal-plan-buttons">
                            <button class="list-action list-action-1" @click="editMealPlan(mealPlanId)">Edit Plan</button>
                            <button class="list-action list-action-2" @click="deletePlan()">Delete Plan</button>
                            <button class="list-action list-action-2" @click="createGroceryList()">Create Grocery List</button>
                        </div>
                    </div>
                </div>
                <div class="dates-wrapper meal-plan-dates">
                    <div class="date-wrapper" v-for="(day, date) in days">
                        <div class="date-heading">
                            <p>{{prettyDate(date)}}</p>
                        </div>
                        <div class="section-for-recipes">
                            <div v-for="scheduled in day" class="recipe-on-date">
                                <div class="recipe-on-date-info">
                                    <span class="date-category">{{scheduled.recipe.category.title}}</span>
                                    <router-link :to="{ name: 'recipe', params: { id: scheduled.recipe.id }}" class="date-recipe-title meal-plan-recipe">{{scheduled.recipe.title}}</router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {createMissingDays} from "./meal_plan_calculator";

    export default {
        data() {
            return {
                days: [],
                startDay: '',
                endDay: '',
                mealPlanId : this.$route.params.id
            }
        },

        mounted() {
            axios.get('api/v1/meal_planning_group/' + this.mealPlanId).then((response) => {
                let data = response.data;

                let startDate = moment(data.start_date);
                let endDate = moment(data.end_date);

                this.days = createMissingDays(data.days, startDate, endDate);

                this.startDay = this.prettyDate(data.start_date);
                this.endDay = this.prettyDate(data.end_date);
            });
        },

        methods: {
            /**
             * @param existingDays array
             * @param startDate Moment
             * @param endDate Moment
             */
            createMissingDays(existingDays, startDate, endDate) {
                let startDay = startDate;
                let amountOfDays = endDate.diff(startDay, 'days');
                let startDayFormatted = startDate.format('YYYY-MM-DD');
                let result = {};

                if (!existingDays.hasOwnProperty(startDayFormatted)) {
                    result[startDayFormatted] = [];
                } else {
                    result[startDayFormatted] = existingDays[startDayFormatted];
                }

                for (let i = 0; i < amountOfDays; i++) {
                    let dateToCheck = startDay.add(1, 'd').format('YYYY-MM-DD');
                    if (!existingDays.hasOwnProperty(dateToCheck)) {
                        result[dateToCheck] = [];
                    } else {
                        result[dateToCheck] = existingDays[dateToCheck];
                    }
                }

                return result;
            },

            prettyDate: (date) => {
                return moment(date).format("dddd, MMMM Do")
            },

            deletePlan() {
                if(confirm('Do you want to delete this meal plan?')) {
                    axios.delete('api/v1/meal_planning_group/' + this.mealPlanId).then((response) => {
                        this.$router.push({path : `/mealplans`});
                    });
                }
            },

            createGroceryList() {
                axios.post('api/v1/meal_plan_list/' + this.mealPlanId).then((response) => {
                    this.$router.push({path : `/grocery-lists/${response.data.grocerylist.id}`});
                })
            },

            editMealPlan(id) {
                this.$router.push({path: `/mealplan/${id}/edit`})
            },
        }
    }
</script>
