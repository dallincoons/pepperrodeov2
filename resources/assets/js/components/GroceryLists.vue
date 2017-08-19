<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Grocery Lists Component</div>

                    <div class="panel-body">
                        <ul>
                            <li v-for="list in grocerylists"><router-link :to="{ name: 'grocery-list', params: { id: list.id }}">{{list.title}}</router-link></li>
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
                grocerylists : []
            }
        },
        mounted() {
            axios.get('/api/v1/grocery-lists').then((response) => {
                this.grocerylists = response.data;
                console.log(response.data);
            });
        }

    }
</script>
