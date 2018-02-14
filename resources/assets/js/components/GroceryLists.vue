<template>
    <div class="container">
        <div class="mod-container" id="newListModal">
            <div>Modal Thing</div>
        </div>

        <div class="container-heading">
            <h2 class="small-screen">Lists</h2>
            <div class="button-wrapper">
                <button class="sq-button" @click="newListModal"><add-icon-dark class="button-icon"></add-icon-dark> New List</button>
                <button class="sq-button" @click="toggleSearch"><search class="button-icon"></search>Search</button>
            </div>

            <div class="drop-wrapper" id="searchBox">
                <caret class="drop-caret"></caret>
                <input type="text" class="drop-input"><button class="drop-button">Search</button>
                <div class="radio-wrapper">
                    <span><input type="radio" value="Alphabetical"> Alphabetical</span>
                    <span><input type="radio" value="Recently Added"> Recently Added</span>
                </div>
            </div>



        </div>


        <div class="container-body">

            <ul class="list-container" id="list-container">
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
    import Caret from './assets/caret.vue';
    import EditItemModal from './GroceryList/EditItemModal.vue';


    export default {
        components : {
            AddIconDark,
            Search,
            Caret,
            EditItemModal,

        },
        data(){
            return {
                grocerylists : [],
                searchQuery : '',
                searchOpen : false,
                showModal   : false
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
                let listContainer = document.getElementById("list-container");
                let searchBox = document.getElementById("searchBox");
                if(this.searchOpen === false) {
                    this.searchOpen = true;
                    listContainer.classList.add("margin-transition");
                    searchBox.classList.add("show-box");
                } else {
                    this.searchOpen = false;
                    listContainer.classList.remove("margin-transition");
                    searchBox.classList.remove("show-box");
                }

            },
            newListModal() {
                let newListModal = document.getElementById("newListModal");
                newListModal.classList.add("show-modal");
            }

            // toggleSearch() {
            //     if(this.searchClosed === true) {
            //         this.searchClosed = false;
            //     } else {
            //         this.searchGroceryLists();
            //     }
            // }
        }
    }
</script>
