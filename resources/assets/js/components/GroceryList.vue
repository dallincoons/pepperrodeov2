<template>
    <div class="container">

        <div class="container-heading"><h2>{{listTitle}}</h2></div>

        <div class="container-body">
            <div class="add-item-wrapper">
                <div class="add-item">
                    <input title="description" v-model="description" @keyup.enter="saveItem" placeholder="+ Add an Item">
                </div>
                <select v-model="department" class="dept-options">
                    <option value="" disabled selected style="display: none;">Department</option>
                    <option v-for="department in departments" :value="department.id">{{department.name}}</option>
                </select>
                <button @click="saveItem" @enter="saveItem" class="save"><span>Save Item</span></button>
            </div>

            <div class="department-container" v-for="(items, department_name) in itemsGrouped"><div class="dept_heading">{{department_name}}</div>
                <ul class="list-items">
                    <li v-for="item in items" class="list-item" @dblclick="openEditItem(item)">
                        <span @click="toggleItem(item.id)" class="checkbox" v-bind:class="{checkmark : item.is_checked}"></span>
                        <span class="item" v-bind:class="{checked : item.is_checked}">{{item.quantity}} {{item.description}}</span>

                        <modal v-if="showModal" @close="displayModal">

                            <span class="close-modal" @click="displayModal" transition="modal">x</span>
                            <h3 class="modal-header">Edit Item</h3>
                            <div class="modal-edit-section">
                                <input class="modal-edit-input" :value="itemToUpdate.description" v-model="itemToUpdate.description">
                                <button class="modal-button" @click="updateItem(item)">Save</button>

                            </div>
                            <div class="modal-edit-footer">
               <span class="modal-delete-img"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 59 59" style="enable-background:new 0 0 59 59;" xml:space="preserve" width="16px" height="16px">
<g>
	<path d="M29.5,51c0.552,0,1-0.447,1-1V17c0-0.553-0.448-1-1-1s-1,0.447-1,1v33C28.5,50.553,28.948,51,29.5,51z" fill="#ff4b2e"/>
	<path d="M19.5,51c0.552,0,1-0.447,1-1V17c0-0.553-0.448-1-1-1s-1,0.447-1,1v33C18.5,50.553,18.948,51,19.5,51z" fill="#ff4b2e"/>
	<path d="M39.5,51c0.552,0,1-0.447,1-1V17c0-0.553-0.448-1-1-1s-1,0.447-1,1v33C38.5,50.553,38.948,51,39.5,51z" fill="#ff4b2e"/>
	<path d="M52.5,6H38.456c-0.11-1.25-0.495-3.358-1.813-4.711C35.809,0.434,34.751,0,33.499,0H23.5c-1.252,0-2.31,0.434-3.144,1.289   C19.038,2.642,18.653,4.75,18.543,6H6.5c-0.552,0-1,0.447-1,1s0.448,1,1,1h2.041l1.915,46.021C10.493,55.743,11.565,59,15.364,59   h28.272c3.799,0,4.871-3.257,4.907-4.958L50.459,8H52.5c0.552,0,1-0.447,1-1S53.052,6,52.5,6z M21.792,2.681   C22.24,2.223,22.799,2,23.5,2h9.999c0.701,0,1.26,0.223,1.708,0.681c0.805,0.823,1.128,2.271,1.24,3.319H20.553   C20.665,4.952,20.988,3.504,21.792,2.681z M46.544,53.979C46.538,54.288,46.4,57,43.636,57H15.364   c-2.734,0-2.898-2.717-2.909-3.042L10.542,8h37.915L46.544,53.979z" fill="#ff4b2e"/>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
</svg></span><span class="modal-delete" @click="deleteItem(item)">Delete Item</span>
                            </div>
                            <div class="modal-line"></div>
                        </modal>

                    </li>

                </ul>
            </div>

        </div>
    </div>

</template>

<script>
    import Modal from './Modal.vue';

    export default {
        components : {
            'modal' : Modal
        },
        data(){
            return {
                showModal   : false,
                listId      : '',
                listTitle   : '',
                listitems   : '',
                description : '',
                editingItem : '',
                departments : '',
                department  : '',
                itemToUpdate : ''
            }
        },

        computed : {
            itemsGrouped : function () {
                return _.chain(this.listitems)
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
            axios.get('/api/v1/grocery-list/' + this.listId).then((response) => {
                let responseData = response.data;
                this.listTitle = responseData.title;
                this.listitems = responseData.items;

            });


            axios.get('/api/v1/departments').then((response) => {
                this.departments = response.data;
            });


        },
        methods    : {

            displayModal() {
                this.showModal = false;
            },

            getList() {
                axios.get('/api/v1/grocery-list/' + this.listId).then((response) => {
                    let responseData = response.data;
                    this.listTitle = responseData.title;
                    this.listitems = responseData.items;
                });
            },

            toggleItem(itemId) {
                axios.post('/api/v1/grocery-list-item-completion/' + itemId).then((response) => {
                    let itemToUpdate        = this.listitems.find(function (item) {
                        return item.id == itemId;
                    });
                    itemToUpdate.is_checked = response.data.is_checked;
                });
            },

            saveItem() {
                let itemDetails = {
                    grocery_list_id : this.listId,
                    description     : this.description,
                    department_id   : this.department
                };
                axios.post('/api/v1/grocery-list-item', itemDetails).then((response) => {
                    this.getList();
                    this.description = '';
                    this.department  = '';
                })
            },

            editItem(item) {
                EventBus.$emit('grocerylist.update.show', {item : item});
            },

            updateItem() {
                this.showModal = false;
                axios.patch('/api/v1/grocery-list-item/' + this.itemToUpdate.id, {description : this.itemToUpdate.description}).then((response) => {
                    this.getList();
                });


            },

            openEditItem(item) {
                this.showModal = true;
                this.itemToUpdate = item;


            },

            deleteItem() {
                this.showModal = false;
                axios.delete('/api/v1/grocery-list-item/' + this.itemToUpdate.id).then((response) => {
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

    .checkmark {
        background: rgba(25, 25, 25, .3);
    }

    .item {
        padding-left: 10px;
    }

    .modal-line {
        height: 5px;
        background-color: #ff4b2e;
        border-radius: 0 0 5px 5px;
        position: absolute;
        bottom: 0;
        width: 100%;

    }

    .modal-header {
        margin-top: 0;
        color: #4f4f4f;
        text-align: center;
        font-weight: 300;
    }

    .modal-edit-section {
        display: flex;
        flex-direction: column;
        justify-content: center;
        margin: 15px;
    }

    .modal-button {
        background: #ff4b2e;
        color: #FFFFFF;
        margin: 15px 0;
        border: 0;
        border-radius: 5px;
        padding: 5px 20px;
        font-weight: 700;
        font-size: 1.2em;
    }

    .modal-button:hover {
        background: #BF3822;
        transition: background 2s;
    }

    .modal-edit-input {
        width: 100%;
        background: #ebebeb;
        border: none;
        font-size: 1.2em;
        padding: 5px 20px;
    }

    .modal-edit-footer {
        align-self: flex-end;
        text-align: right;
        color: #ff4b2e;
        padding: 2px;
        margin-left: 15px;
    }

    .modal-edit-footer:hover {
        cursor: pointer;
    }

    .modal-delete {
        margin: 0 15px 0 2px;
    }
    .close-modal {
        position: absolute;
        right: 0;
        top: 0;
        font-weight: 700;
        font-size: 1.2em;
        margin-right: 5px;
    }

    .close-modal:hover {
        cursor: pointer;
    }




</style>
