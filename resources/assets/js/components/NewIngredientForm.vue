<template>
    <div class="main">
        <div class="grid-heading">
            <div class="grid-row-1">
                <div class="grid-item"><span class="grid-label">Title</span><input type="text" required></div>
                <div class="grid-item"><span class="grid-label">Category</span><input type="text" required></div>
            </div>
            <div class="grid-row-2">
                <div class="grid-item"><span class="grid-label">Prep Time</span><input type="text"></div>
                <div class="grid-item"><span class="grid-label">Total Time</span><input type="text"></div>
                <div class="grid-item"><span class="grid-label">Serves</span><input type="text"></div>
            </div>
        </div>
        <div class="main-content">
            <div class="toggleSection">
                <h4 @click="toggleIngredients = true">Ingredients</h4>
                <h4 @click="toggleIngredients = false">Directions</h4>
            </div>
            <div v-show="toggleIngredients">
                <input class="ingredients-input"><span>+</span>
                <ul>
                    <li>cool</li>
                </ul>
                <h5>Need to Buy</h5>
                <ul>
                    <li>cool</li>
                </ul>
            </div>

            <div v-show="!toggleIngredients">
                <textarea></textarea>
            </div>
            <div>
                <button>Save</button>
                <button>Cancel</button>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props   : ['recipeTitle', 'recipeCat'],
        data() {
            return {
                ingredientDescription : '',
                ingredients           : [],
                needToBuys            : [],
                directions            : '',
                departments           : '',
                toggleIngredients     : true
            }
        },
        mounted() {
            axios.get('/api/v1/departments').then((response) => {
                this.departments = response.data;
            });
        },

        methods : {
            saveRecipe() {
                this.$emit('save', this.directions, this.ingredients, this.needToBuys);
            },

            addIngredient() {
                if (this.ingredientDescription === '') {
                    return;
                }

                let newIngredient = {description : this.ingredientDescription};
                this.ingredients.push(newIngredient);
                this.needToBuys.push(Object.assign({}, newIngredient));
                this.ingredientDescription = '';
            },

            deleteIngredient(index) {
                this.ingredients.splice(index, 1);
            },

            deleteNeedToBuy(index) {
                this.needToBuys.splice(index, 1);
            },

        }
    }
</script>
