<template>
    <div class="container">
        <modal
            v-if="newGroceryListModalShown"
            @close="newGroceryListModalShown = !newGroceryListModalShown"
        >
            <span slot="close" class="modal-close">X</span>
            <h4 class="modal-heading">Add New List</h4>
            <div class="container-create">
                <form v-on:submit.prevent class="create-form">
                    <input title="Grocery List Title" v-model="listTitle" @keyup.enter="saveTitle()" class="title-input" placeholder="List Title">
                    <button type="button" @click="saveTitle()" class="dk-modal-button">Next</button>
                </form>
            </div>
        </modal>

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

        <div class="container-body" id="body-container">

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
    import Caret from './assets/caret.vue';
    import EditItemModal from './GroceryList/EditItemModal.vue';
    import Modal from './Modal.vue';

    export default {
        components : {
            AddIconDark,
            Search,
            Caret,
            EditItemModal,
            Modal
        },
        data(){
            return {
                grocerylists: [],
                searchQuery: '',
                searchOpen: false,
                showModal: false,
                newGroceryListModalShown: false,
                listTitle : '',
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
                let bodyContainer = document.getElementById("body-container");
                let searchBox = document.getElementById("searchBox");
                if(this.searchOpen === false) {
                    this.searchOpen = true;
                    bodyContainer.classList.add("margin-transition");
                    searchBox.classList.add("show-box");
                } else {
                    this.searchOpen = false;
                    bodyContainer.classList.remove("margin-transition");
                    searchBox.classList.remove("show-box");
                }

            },

            newListModal() {
                this.newGroceryListModalShown = true;
            },

            hideNewGroceryListModal() {
                this.newGroceryListModalShown = false;
            },
            saveTitle() {
                axios.post('/api/v1/grocery-lists', {title : this.listTitle}).then((response) => {
                    this.$router.push({ path: `/grocery-lists/${response.data.data.id}` });
                });
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
