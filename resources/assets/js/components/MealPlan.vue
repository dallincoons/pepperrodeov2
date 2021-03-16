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
                            <div v-for="scheduled in day.recipes" class="recipe-on-date">
                                <div class="recipe-on-date-info">
                                    <span class="date-category">{{scheduled.recipe.category.title}}</span>
                                    <router-link :to="{ name: 'recipe', params: { id: scheduled.recipe.id }}" class="date-recipe-title meal-plan-recipe">{{scheduled.recipe.title}}</router-link>
                                </div>
                            </div>
                            <div v-for="scheduled in day.items" class="recipe-on-date items-on-date" v-if="day.items.length > 0">
                                <p class="date-category">Additional Items</p>
                                <p class="date-recipe-title meal-plan-recipe">{{scheduled.title}}</p>
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
                days: [],
                startDay: '',
                endDay: '',
                mealPlanId : this.$route.params.id
            }
        },

        mounted() {

            axios.get('api/v1/meal_planning_group/' + this.mealPlanId).then((response) => {
                console.log(response);
                this.days = response.data;

                this.startDay = this.prettyDate(Object.keys(this.days)[0]);
                this.endDay = this.prettyDate(Object.keys(this.days)[Object.keys(this.days).length-1]);
            })

        },

        methods: {
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
