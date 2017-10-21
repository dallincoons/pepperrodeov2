<template>
    <div class="container">

        <div class="container-heading list-heading">
            <h2>{{list.title}}</h2>
        </div>

        <div class="container-body">
            <div class="add-item-section" @click="toggleAddItemSection">
                <span class="add-item-text">Add Item</span>
                <new-item-form @updated="getList" :departments="departments" v-bind:class="{showy : addItemFormOpened, hidey : !addItemFormOpened}"></new-item-form>
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
                addItemFormOpened : false
            }
        },

        computed : {
            itemsGrouped : function () {
                return _.chain(this.list.items)
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
        },
        methods    : {

            hideModal() {
                this.showModal = false;
            },

            displayModal() {
                this.showModal = true;
            },

            getList() {
                axios.get('/api/v1/grocery-list/' + this.listId).then((response) => {
                    this.list = response.data;
                    if( ! this.list.items.length) {
                        this.addItemFormOpened = true;
                    }
                });
            },

            getDepartments() {
                axios.get('/api/v1/departments').then((response) => {
                    this.departments = response.data;
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

            toggleAddItemSection() {
                this.addItemFormOpened = ! this.addItemFormOpened;
            }
        }
    }
</script>
