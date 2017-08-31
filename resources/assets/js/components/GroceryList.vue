<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Grocery List Component</div>

                    <div class="panel-body">
                        <input title="description" v-model="description" @keyup.enter="saveItem">
                        <h2>{{listTitle}}</h2>
                        <ul>
                            <li v-for="item in listitems" @click="toggleItem(item.id)" v-bind:class="{checked : item.is_checked}">{{item.quantity}} {{item.description}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                listId : '',
                listTitle : '',
                listitems : '',
                description : ''
            }
        },
        mounted() {
            this.listId = this.$route.params.id;
            axios.get('/api/v1/grocery-list/'+this.listId).then((response) => {
                let responseData = response.data;
                this.listTitle = responseData.title;
                this.listitems = responseData.items;
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
                axios.post('/api/v1/grocery-list-item', {grocery_list_id : this.listId, description : this.description}).then((response) => {
                        this.getList();
                        this.description = '';
                })
            }
        }

    }
</script>
