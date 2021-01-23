<template>
    <div class="container recipes-main-wrapper">
        <div class="recipes-secondary-wrapper">
            <div class="recipes-heading"><h3>Meal Plans</h3></div>
            <div class="recipes-button-wrapper">
                <router-link class="recipes-action" to="/mealplanning">Create New Meal Plan</router-link>
            </div>
            <div class="recipes-body">
                <div class="category-container">
                    <div class="container-body recipes-wrapper plans-container">
                        <ul class="recipes-list">
                            <li class="recipe-ingredient" v-for="plan in plans">
                                <router-link :to="{name: 'meal-plan', params: { id: plan.id}}">{{plan.name}}</router-link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import _ from 'lodash';

    export default {
        components: {
        },

        data() {
            return {
                plans : []
            }
        },

        computed: {

        },

        mounted() {
            this.getPlans();

        },

        methods: {
            getPlans() {
                axios.get('/api/v1/meal_planning_groups').then((response) => {
                    this.plans = response.data;
                })
            },

        }
    }
</script>
