<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Grocery List Component</div>

                    <div class="panel-body">
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
                listTitle : '',
                listitems : ''
            }
        },
        mounted() {
            console.log(this.$route.params.id);
            let listId = this.$route.params.id;
            axios.get('/api/v1/grocery-list/'+listId).then((response) => {
                let responseData = response.data;
                this.listTitle = responseData.title;
                this.listitems = responseData.items;
                console.log(responseData.items);
            });
        },
        methods: {
            toggleItem(itemId) {
                axios.post('/api/v1/grocery-list-item-completion/'+itemId).then((response)=>{
                    let itemToUpdate = this.listitems.find(function(item){
                        return item.id == itemId;
                    });
                    itemToUpdate.is_checked = response.data.is_checked;
                });
            },
        }

    }
</script>
