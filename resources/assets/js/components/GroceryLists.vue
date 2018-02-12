<template>
    <div class="container">
        <div class="container-heading">
        <h2>Lists</h2>
        <div class="button-wrapper">
            <router-link class="sq-button" to="/grocery-lists/create"><add-icon-dark class="button-icon"></add-icon-dark> New List</router-link>
            <button class="sq-button"><search class="button-icon"></search>Search</button>
        </div>
        </div>


        <div class="container-body">

            <ul class="list-container">
                <li v-for="list in grocerylists" class="grocery-list grow"><router-link :to="{ name: 'grocery-lists', params: { id: list.id }}" >{{list.title}}</router-link></li>
            </ul>
            <add-icon-dark></add-icon-dark>

        </div>
    </div>
</template>

<script>
    import GroceryLists from './resources/GroceryLists';
    import AddIconDark from './assets/add-icon-dark.vue';
    import Search from './assets/search.vue';

    export default {
        components : {
            AddIconDark,
            Search

        },
        data(){
            return {
                grocerylists : [],
                searchQuery : '',
                searchClosed : true,
            }
        },

        mounted() {
            GroceryLists.get().then((response) => {
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
