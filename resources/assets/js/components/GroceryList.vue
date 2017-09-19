<template>
    <div class="container">
        <button @click="showModal = true">Show Modal</button>
        <modal v-if="showModal" @close="showModal = false">
           <h2>hey there</h2>
        </modal>

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
                    <li v-for="item in items" class="list-item" @dblclick="editItem(item)">
                        <span @click="toggleItem(item.id)" class="checkbox" v-bind:class="{checkmark : item.is_checked}"></span>
                        <span class="item" v-bind:class="{checked : item.is_checked}">{{item.quantity}} {{item.description}}</span>

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
                showModal : false,
                listId : '',
                listTitle : '',
                listitems : '',
                description : '',
                editingItem : '',
                departments: '',
                department: '',
            }
        },

        computed: {
            itemsGrouped : function() {
                return _.chain(this.listitems)
                    .sortBy(function(item){
                        return item.department.name;
                    })
                    .groupBy(function(item){
                        return item.department.name;
                    }).value();
            }
        },

        mounted() {

            this.listId = this.$route.params.id;
            axios.get('/api/v1/grocery-list/'+this.listId).then((response) => {
                let responseData = response.data;
                this.listTitle = responseData.title;
                this.listitems = responseData.items;

            });
            EventBus.$on('deleteItem', (prams) => {
                this.deleteItem(prams.id);
            });
            axios.get('/api/v1/departments').then((response) => {
                this.departments = response.data;
            });


            EventBus.$on('updateItem', (prams) => {
                    axios.patch('/api/v1/grocery-list-item/'+prams.id, {description : prams.description}).then((response) => {
                    this.getList();
                })
            });

        },
        methods: {
            getList() {
                axios.get('/api/v1/grocery-list/'+this.listId).then((response) => {
                    let responseData = response.data;
                    this.listTitle = responseData.title;
                    this.listitems = responseData.items;
                });
            },

            toggleItem(itemId) {
                axios.post('/api/v1/grocery-list-item-completion/'+itemId).then((response)=>{
                    let itemToUpdate = this.listitems.find(function(item){
                        return item.id == itemId;
                    });
                    itemToUpdate.is_checked = response.data.is_checked;
                });
            },

            saveItem() {
            let itemDetails = {grocery_list_id : this.listId, description : this.description, department_id : this.department};
                axios.post('/api/v1/grocery-list-item', itemDetails).then((response) => {
                        this.getList();
                        this.description = '';
                        this.department = '';
                })
            },

            editItem(item) {
                EventBus.$emit('grocerylist.update.show', {item : item});
            },


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

    .edit-item-hidden {
        display: none;
    }

    .edit-item {

    }


</style>
