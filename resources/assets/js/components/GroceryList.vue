<template>
    <div class="container">
        <full-screen-modal
                v-if="addRecipesModalShown"
                @close="addRecipesModalShown = !addRecipesModalShown"
        >
            <div class="fs-header">
                <h4 class="fs-heading">Add Recipe(s)</h4>
                <button @click="addRecipesToList" class="fs-button">Add</button>
            </div>

            <div>
                <ul class="fs-list">

                    <li v-for="recipe in recipes" class="fs-list-item">
                        <div class="fs-checkbox">
                            <input type="checkbox" :id="'checkbox_' + recipe.id" :value="recipe.id" v-model="checkedRecipes">
                            <label :for="'checkbox_' + recipe.id">{{recipe.title}}</label>
                        </div>

                    </li>
                </ul>

            </div>
        </full-screen-modal>

        <div class="container-heading list-heading">
            <h2 v-if="!editable">{{list.title}}</h2><input v-else v-model="list.title" style="color: #3f3f3f">
            <div class="button-wrapper">
                <button class="sq-button" @click="toggleAddItems"> Add Item</button>
                <button class="sq-button" @click="viewRecipes">Add Recipe(s)</button>
            </div>
             <!--<span v-if="!editable" @click="editable = true">Edit Title</span>-->
            <!--<span @click="updateListTitle" v-else>Save Title</span>-->
            <div class="drop-wrapper" id="drop-wrapper">
                <caret class="add-item-caret drop-caret"></caret>
                <new-item-form @updated="getList" :departments="departments"></new-item-form>
            </div>
        </div>

        <div class="container-body ex-neg-margin" id="body-container">
            <div class="add-item-section">
                <!--<span class="add-item-text">Add Item</span>-->
                <!--<new-item-form @updated="getList" :departments="departments"></new-item-form>-->


            </div>
            <div class="list-wrapper" id="list-wrapper">
                <div class="department-container" v-for="(items, department_name) in itemsGrouped"><div class="dept_heading">{{department_name}}</div>
                    <ul class="list-items">
                        <li v-for="item in items" class="list-item" @dblclick="openEditItem(item)">
                            <span @click="toggleItem(item.id)" class="checkbox" v-bind:class="{checkmark : item.is_checked}"></span>
                            <span class="item" v-bind:class="{checked : item.is_checked}">{{item.quantity}} {{item.description}}</span>

                            <edit-item-modal
                                    v-if="showModal"
                                    :itemToUpdate="itemToUpdate"
                                    :departments="departments"
                                    @close="hideModal"
                                    @update="updateItem"
                                    @delete="deleteItem"
                            ></edit-item-modal>
                        </li>

                    </ul>
                </div>
            </div>

        </div>
    </div>

</template>

<script>
    import EditItemModal from './GroceryList/EditItemModal.vue';
    import NewItemForm from './GroceryList/NewItemForm.vue';
    import Caret from './assets/caret.vue';
    import FullScreenModal from './FullScreenModal.vue';

    export default {

        components : {
            EditItemModal,
            NewItemForm,
            Caret,
            FullScreenModal
        },

        data(){
            return {
                showModal   : false,
                list        : {},
                listId      : '',
                description : '',
                departments : '',
                itemToUpdate : '',
                editable     : false,
                recipes      : [],
                checkedRecipes : [],
                dropOpen : false,
                addRecipesModalShown : false
            }
        },

        computed : {
            itemsGrouped : function () {
                return _.chain(this.list.combinedItems)
                    .sortBy(function (item) {
                        return item.department.name;
                    })
                    .groupBy(function (item) {
                        return item.department.name;
                    }).value();
            }
        },

        mounted() {
            this.listId = this.$route.params.id;
            this.getList();
            this.getDepartments();
            this.getRecipes();
        },
        methods    : {

            hideModal() {
                this.showModal = false;
            },

            displayModal() {
                this.showModal = true;
            },

            getList() {
                axios.get('/api/v1/grocery-lists/' + this.listId).then((response) => {
                    console.log(response.data);
                    this.list = response.data;
                });
            },

            getDepartments() {
                axios.get('/api/v1/departments').then((response) => {
                    this.departments = response.data;
                });
            },

            getRecipes() {
                axios.get('/api/v1/recipes').then((response) => {
                    this.recipes = response.data;
                });
            },

            toggleItem(itemId) {
                axios.post('/api/v1/grocery-list-item-completion/' + itemId).then((response) => {
                    let itemToUpdate = this.list.items.find(function (item) {
                        return item.id == itemId;
                    });
                    itemToUpdate.is_checked = response.data.is_checked;
                });
            },

            updateItem(itemToUpdate) {
                this.hideModal();
                axios.patch('/api/v1/grocery-list-item/' + itemToUpdate.id, {magic_description : itemToUpdate.description, department_id : itemToUpdate.department_id}).then((response) => {
                    this.getList();
                });
            },

            openEditItem(item) {
                this.itemToUpdate = item;
                this.displayModal();
            },

            deleteItem(itemToUpdate) {
                this.hideModal();
                axios.delete('/api/v1/grocery-list-item/' + itemToUpdate.id).then((response) => {
                    this.getList();
                });
            },

            updateListTitle() {
                axios.patch('/api/v1/grocery-lists/' + this.listId, {
                    title       : this.list.title,
                }).then((response) => {
                    this.getList();
                    this.editable = false;
                });
            },


            viewRecipes() {
                this.addRecipesModalShown = true;
                console.log(this.addRecipesModalShown);
            },

            addRecipesToList() {
                axios.post('/api/v1/grocerylist/' + this.listId + '/add-recipes', {
                    recipes : this.checkedRecipes
                }).then((response) => {
                    this.addRecipesModalShown = false;
                    this.getList();
                    this.checkedRecipes = [];
                });
            },

            toggleAddItems() {
                let bodyContainer = document.getElementById("body-container");
                let dropWrapper = document.getElementById("drop-wrapper");
                if(this.dropOpen === false) {
                    this.dropOpen = true;
                    bodyContainer.classList.add("margin-transition");
                    dropWrapper.classList.add("show-box");
                } else {
                    this.dropOpen = false;
                    bodyContainer.classList.remove("margin-transition");
                    dropWrapper.classList.remove("show-box");
                }

            },
        }
    }
</script>
