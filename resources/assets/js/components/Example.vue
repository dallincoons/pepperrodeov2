<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Example Component</div>

                    <div class="panel-body">
                        An example component
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
                console.log(response.data);
            });
        }
    }
</script>
