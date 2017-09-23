<template>
    <div class="container">

        <div class="container-heading"><h2>{{list.title}}</h2></div>

        <div class="container-body">
            <new-item-form @updated="getList" :departments="departments"></new-item-form>

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
                itemToUpdate : ''
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
                axios.patch('/api/v1/grocery-list-item/' + itemToUpdate.id, {description : itemToUpdate.description, department_id : itemToUpdate.department_id}).then((response) => {
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
            }
        }
    }
</script>

<style>

    body {
        width: 100%;
        background: #fff4f0;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .container {
        width: 60%;
        background: #fff;
        display: flex;
        flex-direction: column;
        border-radius: 10px;
        -webkit-box-shadow: 0 0 15px 5px rgba(27,26,26,0.14);
        -moz-box-shadow: 0 0 15px 5px rgba(27,26,26,0.14);
        box-shadow: 0 0 15px 5px rgba(27,26,26,0.14);
        margin-bottom: 40px;
        margin-top: 50px;
    }

    .container-heading {
        background: #ff4b2e;
        margin: 0 -15px;
        border-radius: 10px 10px 0 0;
        color: #fff;
        padding: 0 0 0 2%;
    }

    .container-heading h2 {
        font-weight: 200;
        margin-top: 11px;
    }

    .container-body {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .add-item-wrapper {
        width: 100%;
        display: flex;
    }

    .dept-options {
        margin: 10px;
        display: flex;
        color: #757575;
        font-size: 1.2em;
        border-radius: 0;
        border: none;
        background: #ebebeb;
        width: 20%;
    }

    .save {
        display: flex;
        border: none;
        color: #757575;
        font-size: 1.2em;
        background: #ebebeb;
        margin: 10px 0;
        width:10%;
        transition: background 2s;
        justify-content: center;
        align-items: center;
    }
    .save:hover {
        background: #D1D1D1;
        transition: background 2s;
        cursor: pointer;
    }

    .add-item {
        width: 70%;
        margin: 10px 0;
    }

    .add-item input {
        width: 100%;
        background: #ebebeb;
        border: none;
        padding: 1%;
        font-size: 1.2em;
    }

    .list-items {
        width: 100%;
        display: flex;
        flex-direction: column;
        padding: 0;
    }
    .department-container {
        width: 100%;
    }

    .dept_heading {
        background: #ff4b2e;
        color: #ffffff;
        font-size: 1.5em;
        margin: 0 -15px;
        padding: 0 0 0 2%;
    }

    .list-item {
        width: 100%;
        -webkit-box-shadow: 1px 3px 2px 1px rgba(27,26,26,0.1);
        -moz-box-shadow: 1px 3px 2px 1px rgba(27,26,26,0.1);
        box-shadow: 1px 3px 2px 1px rgba(27,26,26,0.1);
        margin: 10px 0;
        font-size: 1.2em;
        display: flex;
        border-radius: 5px;
        border-top: 1px solid rgba(27,26,26,.1);
        padding: 5px;
        align-items: center;
    }

    .checkbox {
        width: 20px;
        height: 20px;
        border: 1px solid #555555;
        display: flex;
        margin: 0;
    }

    /* displayed dynamically */
    .checkmark {
        background: rgba(25, 25, 25, .3);
    }

    .item {
        padding-left: 10px;
    }

</style>
