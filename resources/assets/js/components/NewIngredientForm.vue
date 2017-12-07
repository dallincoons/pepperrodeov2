<template>
    <div>
        <div class="heading-section">
            <h2>{{recipeTitle}}</h2>
            <h5>{{recipeCat.title}}</h5>
        </div>
        <div class="add-ingredient-section">
            <form class="add-ingredient-form">
                <div class="ingredient-section">
                    <h4 class="add-ingredient-headings">Ingredients</h4>
                    <input title="recipe ingredients" id="ingredients" v-model="ingredientDescription"
                           class="ingredients-input"> <span @click="addIngredient" class="add-ingredient">+</span>
                    <div class="saved-ingredients">
                        <ul class="list-of-ingredients">
                            <li v-for="(ingredient, index) in ingredients" class="ingredient-item"><span
                                    class="ingredient-description">{{ingredient.description}}</span><span
                                    @click="deleteIngredient(index)" class="remove-item">x</span></li>
                        </ul>
                    </div>
                </div>

                <div class="need-to-buy">
                    <h4 class="add-ingredient-headings buy-heading">Need to Buy</h4>
                    <ul class="buy-item-list">
                        <li v-for="(needToBuy, index) in needToBuys" class="need-buy-list-items"><input :value="needToBuy.description"
                                                                            v-model="needToBuy.description"
                                                                            class="buy-item"><span
                                @click="deleteNeedToBuy(index)" class="remove-item">x</span></li>
                    </ul>
                </div>
                <div class="directions">
                    <label for="directions" class="add-ingredient-headings">Directions</label>
                    <textarea id="directions" v-model="directions" class="directions-input"></textarea>
                </div>
                <div class="save-section">
                    <button class="recipe-save save-button" @click="saveRecipe">Save</button>
                </div>

            </form>
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
            }
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
            }
        }
    }
</script>
