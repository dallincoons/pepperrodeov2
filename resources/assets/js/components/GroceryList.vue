<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Grocery List Component</div>

                    <div class="panel-body">

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

            }
        },
        mounted() {
            console.log(this.$route.params.id);
            let listId = this.$route.params.id;
            axios.get('/api/v1/grocery-list/'+listId).then((response) => {
                console.log(response.data);
            });
        }

    }
</script>
