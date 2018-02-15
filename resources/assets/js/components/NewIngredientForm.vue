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
            <!--<div>-->
            <!--<div>-->
                <!--<h3 v-show="toggleIngredients">Ingredients</h3>-->
                <!--<input title="recipe ingredients" id="ingredients" v-model="ingredientDescription"-->
                       <!--class="ingredients-input"> <span @click="addIngredient" class="add-ingredient">+</span>-->
                <!--<div class="saved-ingredients">-->
                    <!--<ul class="list-of-ingredients">-->
                        <!--<li v-for="(ingredient, index) in ingredients" class="ingredient-item"><span-->
                                <!--class="ingredient-description">{{ingredient.description}}</span><span-->
                                <!--@click="deleteIngredient(index)" class="remove-item">x</span></li>-->
                    <!--</ul>-->
                <!--</div>-->

                <!--<div class="need-to-buy">-->
                    <!--<h4 class="add-ingredient-headings buy-heading">Need to Buy</h4>-->
                    <!--<ul class="buy-item-list">-->
                        <!--<li v-for="(needToBuy, index) in needToBuys" class="need-buy-list-items"><input :value="needToBuy.description"-->
                                                                                                        <!--v-model="needToBuy.description"-->
                                                                                                        <!--class="buy-item">-->
                            <!--<select v-model="needToBuy.department_id">-->
                                <!--<option v-for="department in departments" :value="department.id">{{department.name}}</option>-->
                            <!--</select>-->
                            <!--<span @click="deleteNeedToBuy(index)" class="remove-item">x</span></li>-->
                    <!--</ul>-->
                <!--</div>-->
            <!--</div>-->
            <!--<div>-->
                <!--<h3 v-show="!toggleIngredients">Directions</h3>-->
                <!--<div class="directions">-->
                    <!--<label for="directions" class="add-ingredient-headings">Directions</label>-->
                    <!--<textarea id="directions" v-model="directions" class="directions-input"></textarea>-->
                <!--</div>-->
            <!--</div>-->
        <!--</div>-->
        <!--&lt;!&ndash;<div class="heading-section">&ndash;&gt;-->
            <!--&lt;!&ndash;<h2>{{recipeTitle}}</h2>&ndash;&gt;-->
            <!--&lt;!&ndash;<h5>{{recipeCat.title}}</h5>&ndash;&gt;-->
        <!--&lt;!&ndash;</div>&ndash;&gt;-->
        <!--&lt;!&ndash;<div class="add-ingredient-section">&ndash;&gt;-->
            <!--&lt;!&ndash;<form class="add-ingredient-form">&ndash;&gt;-->
                <!--&lt;!&ndash;<div class="ingredient-section">&ndash;&gt;-->
                    <!--&lt;!&ndash;<h4 class="add-ingredient-headings">Ingredients</h4>&ndash;&gt;-->
                    <!--&lt;!&ndash;<input title="recipe ingredients" id="ingredients" v-model="ingredientDescription"&ndash;&gt;-->
                           <!--&lt;!&ndash;class="ingredients-input"> <span @click="addIngredient" class="add-ingredient">+</span>&ndash;&gt;-->
                    <!--&lt;!&ndash;<div class="saved-ingredients">&ndash;&gt;-->
                        <!--&lt;!&ndash;<ul class="list-of-ingredients">&ndash;&gt;-->
                            <!--&lt;!&ndash;<li v-for="(ingredient, index) in ingredients" class="ingredient-item"><span&ndash;&gt;-->
                                    <!--&lt;!&ndash;class="ingredient-description">{{ingredient.description}}</span><span&ndash;&gt;-->
                                    <!--&lt;!&ndash;@click="deleteIngredient(index)" class="remove-item">x</span></li>&ndash;&gt;-->
                        <!--&lt;!&ndash;</ul>&ndash;&gt;-->
                    <!--&lt;!&ndash;</div>&ndash;&gt;-->
                <!--&lt;!&ndash;</div>&ndash;&gt;-->

                <!--&lt;!&ndash;<div class="need-to-buy">&ndash;&gt;-->
                    <!--&lt;!&ndash;<h4 class="add-ingredient-headings buy-heading">Need to Buy</h4>&ndash;&gt;-->
                    <!--&lt;!&ndash;<ul class="buy-item-list">&ndash;&gt;-->
                        <!--&lt;!&ndash;<li v-for="(needToBuy, index) in needToBuys" class="need-buy-list-items"><input :value="needToBuy.description"&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;v-model="needToBuy.description"&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;class="buy-item">&ndash;&gt;-->
                        <!--&lt;!&ndash;<select v-model="needToBuy.department_id">&ndash;&gt;-->
                            <!--&lt;!&ndash;<option v-for="department in departments" :value="department.id">{{department.name}}</option>&ndash;&gt;-->
                        <!--&lt;!&ndash;</select>&ndash;&gt;-->
                        <!--&lt;!&ndash;<span @click="deleteNeedToBuy(index)" class="remove-item">x</span></li>&ndash;&gt;-->
                    <!--&lt;!&ndash;</ul>&ndash;&gt;-->
                <!--&lt;!&ndash;</div>&ndash;&gt;-->
                <!--&lt;!&ndash;<div class="directions">&ndash;&gt;-->
                    <!--&lt;!&ndash;<label for="directions" class="add-ingredient-headings">Directions</label>&ndash;&gt;-->
                    <!--&lt;!&ndash;<textarea id="directions" v-model="directions" class="directions-input"></textarea>&ndash;&gt;-->
                <!--&lt;!&ndash;</div>&ndash;&gt;-->
                <!--&lt;!&ndash;<div class="save-section">&ndash;&gt;-->
                    <!--&lt;!&ndash;<button class="recipe-save save-button" @click="saveRecipe">Save</button>&ndash;&gt;-->
                <!--&lt;!&ndash;</div>&ndash;&gt;-->

            <!--</form>-->
        <!--</div>-->
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
                console.log(this.departments);
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
