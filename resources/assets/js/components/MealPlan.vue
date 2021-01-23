<template>
    <div>
    <h1>meal plan</h1>
    <ul>
        <li v-for="(day, date) in days">
            {{date}}
            <div v-for="scheduled in day">{{scheduled.recipe.title}}</div>
        </li>
    </ul>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                days: []
            }
        },

        mounted() {
           let mealPlanId = this.$route.params.id;

            axios.get('api/v1/meal_planning_group/' + mealPlanId).then((response) => {
                this.days = response.data.days;
            })

        }
    }
</script>
