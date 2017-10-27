<template>
    <div>
    <h2>{{recipeTitle}}</h2>
    <h4>{{recipeCat}}</h4>
        <form>
            <label for="ingredients">Ingredients</label>
            <input title="recipe ingredients" id="ingredients" v-model="ingredientDescription"> <span @click="addIngredient">+</span>
            <div class="saved-ingredients">
                <ul>
                    <li v-for="(ingredient, index) in ingredients">{{ingredient.description}}<span @click="deleteIngredient(index)">x</span></li>
                </ul>
            </div>
            <div class="need-to-buy">
                <h3>Need to Buy</h3>
                <ul>
                    <li v-for="(needToBuy, index) in needToBuys"><input :value="needToBuy.description" v-model="needToBuy.description"><span @click="deleteNeedToBuy(index)">x</span></li>
                </ul>
            </div>
            <label for="directions">Directions</label>
            <textarea id="directions" v-model="directions"></textarea>
            <button>Save</button>
        </form>
    </div>
</template>

<script>
    export default {
        props : ['recipeTitle', 'recipeCat'],
        data() {
            return {
                ingredientDescription : '',
                ingredients : [],
                needToBuys : [],
                directions : ''
            }
        },
        methods : {
            saveRecipe() {
                axios.post('/api/v1/recipes/create', {title : this.recipeTitle, ingredients : [{description : this.ingredientDescription, listable : 1}]}).then((response) => {
                    console.log(response);
                });
            },
            addIngredient() {
                let newIngredient = {description : this.ingredientDescription};
                this.ingredients.push(newIngredient);
                this.needToBuys.push(Object.assign({}, newIngredient));
                this.ingredientDescription = '';
            },

            deleteIngredient(index) {
                this.ingredients.splice(index, 1);
            },
            deleteNeedToBuy(index) {
                this.needToBuys.splice(index,1);
            }
        }

    }

</script>
