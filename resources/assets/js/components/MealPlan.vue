<template>
    <div class="container lists-main-wrapper">
        <div class="list-container">
            <div class="list-wrapper">
                <div class="red-accent-bar"></div>
                <div class="list-heading">
                    <h3 class="list-title">Meal Plan for {{startDay}}</h3>
                    <div class="list-actions-wrapper">
                        <div class="list-actions-buttons meal-plan-buttons">
                            <button class="list-action list-action-1">Edit Plan</button>
                            <button class="list-action list-action-2">Delete Plan</button>
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
                                    <!--<span class="date-category">{{scheduled.recipe.category.title}}</span>-->
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

    export default {
        data() {
            return {
                days: [],
                startDay: '',
                endDay: '',
            }
        },

        mounted() {
           let mealPlanId = this.$route.params.id;

           this.startDay = this.prettyDate(this.days[0]);
           this.endDay = this.days.slice(-1);

            axios.get('api/v1/meal_planning_group/' + mealPlanId).then((response) => {
                this.days = response.data.days;
                console.log(response);
            })

        },

        methods: {
            prettyDate: (date) => {
                return moment(date).format("dddd, MMMM Do")
            }
        }
    }
</script>
