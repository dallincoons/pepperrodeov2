<template>
    <div class="container">

        <div class="container-heading list-heading">
            <h2 v-if="!editable">{{list.title}}</h2><input v-else v-model="list.title" style="color: #3f3f3f">
             <span v-if="!editable" @click="editable = true">Edit Title</span>
            <span @click="updateListTitle" v-else>Save Title</span>
        </div>

        <div class="container-body">
            <div class="add-item-section">
                <span class="add-item-text">Add Item</span>
                <new-item-form @updated="getList" :departments="departments"></new-item-form>
                <div @click="viewRecipes">Add Recipe(s)</div>
                <div>
                    <ul>

                        <li v-for="recipe in recipes"><input type="checkbox" :value="recipe.id" v-model="checkedRecipes">{{recipe.title}}</li>
                    </ul>
                    <button @click="addRecipesToList">Add these to my list please</button>
                </div>
            </div>

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

</template>

<script>
    import EditItemModal from './GroceryList/EditItemModal.vue';
    import NewItemForm from './GroceryList/NewItemForm.vue';

    export default {

        components : {
            EditItemModal,
            NewItemForm
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
                checkedRecipes : []
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

            },

            addRecipesToList() {
                axios.post('/api/v1/grocerylist/' + this.listId + '/add-recipes', {
                    recipes : this.checkedRecipes
                }).then((response) => {
                    this.getList();
                });
            }
        }
    }
</script>
