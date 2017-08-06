<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Grocery List Component</div>

                    <div class="panel-body">
                        <h2>{{listTitle}}</h2>
                        <ul>
                            <li v-for="item in listitem">{{item.quantity}} {{item.description}}</li>
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
                listitem : ''
            }
        },
        mounted() {
            console.log(this.$route.params.id);
            let listId = this.$route.params.id;
            axios.get('/api/v1/grocery-list/'+listId).then((response) => {
                let responseData = response.data;
                this.listTitle = responseData.title;
                this.listitem = responseData.items;
                console.log(responseData.items);
            });
        }

    }
</script>
