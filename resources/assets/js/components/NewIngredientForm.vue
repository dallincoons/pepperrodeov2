<template>
    <div>
        <form>
            <label for="ingredients">Ingredients</label>
            <input title="recipe ingredients" id="ingredients" v-model="recipeDescription"> <span>+</span>
            <div class="saved-ingredients">
                <div>Ingredient1</div>
            </div>
            <div class="need-to-buy">
                <h3>Need to Buy</h3>
                <div>Ingredient1</div>
            </div>
            <label for="directions">Directions</label>
            <textarea id="directions"></textarea>
            <button>Save</button>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                recipeTitle : '',
                recipeDescription : ''
            }
        },
        methods : {
            saveRecipe() {
                axios.post('/api/v1/recipes/create', {title : this.recipeTitle, ingredients : [{description : this.recipeDescription, listable : 1}]}).then((response) => {
                    console.log(response);
                });
            }
        }
    }

</script>
