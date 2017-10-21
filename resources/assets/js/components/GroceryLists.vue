<template>
    <div class="container">
        <div class="container-heading"><h2>My Grocery Lists</h2></div>
        <div class="container-body">

            <ul class="list-container">
                <li v-for="list in grocerylists" class="grocery-list grow"><router-link :to="{ name: 'grocery-list', params: { id: list.id }}" >{{list.title}}</router-link></li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                grocerylists : [],
                searchQuery : '',
                searchClosed : true
            }
        },

        mounted() {
            axios.get('/api/v1/grocery-lists').then((response) => {
                this.grocerylists = response.data.data;
            });

        },
        methods : {
            searchGroceryLists() {
               axios.get('/api/v1/grocery-lists/search?query='+this.searchQuery).then((response) => {
                    this.grocerylists = response.data;
               });
            },

            toggleSearch() {
                if(this.searchClosed === true) {
                    this.searchClosed = false;
                } else {
                    this.searchGroceryLists();
                }

            }
        }
    }
</script>
