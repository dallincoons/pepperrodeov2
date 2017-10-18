<template>
    <div class="container">
        <h2 class="container-heading">Add a Recipe</h2>
        <div class="container-create">
            <form v-on:submit.prevent>
                <input title="Recipe Title" class="title-input" placeholder="Recipe Title" v-model="recipeTitle">
                <input title="recipe ingredients" placeholder="Ingredients" v-model="recipeItem">
                <textarea placeholder="Directions"></textarea>
                <button type="button" class="save-button" @click="saveRecipe">Save</button>
            </form>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                recipeTitle : '',
                recipeItem : ''
            }
        },
        methods : {
            saveRecipe() {
                axios.post('/api/v1/recipes/create', {title : this.recipeTitle, items : [{description : this.recipeItem, listable : 1}]}).then((response) => {
                    console.log(response);
                });
            }
        }
    }

</script>
