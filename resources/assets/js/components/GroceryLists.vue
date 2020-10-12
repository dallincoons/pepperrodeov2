<template>
    <div class="container lists-main-wrapper">
        <div class="lists-secondary-wrapper">
        <!--<modal-->
            <!--v-if="newGroceryListModalShown"-->
            <!--@close="newGroceryListModalShown = !newGroceryListModalShown"-->
        <!--&gt;-->
            <!--<span slot="close" class="modal-close">X</span>-->
            <!--<h4 class="modal-heading">Add New List</h4>-->
            <!--<div class="container-create">-->
                <!--<form v-on:submit.prevent class="create-form">-->
                    <!--<input title="Grocery List Title" v-model="listTitle" @keyup.enter="saveList()" class="title-input" placeholder="List Title">-->
                    <!--<button type="button" @click="saveList()" class="dk-modal-button">Next</button>-->
                <!--</form>-->
            <!--</div>-->
        <!--</modal>-->

        <div>
            <h3 class="lists-heading">My Lists</h3>
            <div class="lists-button-wrapper">
                <button class="lists-action" @click="newListModal" v-bind:class="{ 'selected-action' : newGroceryListModalShown}">Create New List</button>
            </div>
        </div>
            <div class="new-list-wrapper" v-bind:class="{ 'new-list-expand' : newGroceryListModalShown}">
                <div class="container-create">
                    <form v-on:submit.prevent class="create-form">
                        <input title="Grocery List Title" v-model="listTitle" @keyup.enter="saveList()" class="title-input" placeholder="Grocery List Title">
                        <button type="button" @click="saveList()" class="save-button">Next</button>
                    </form>
                </div>
            </div>

        <div class="lists-body" v-bind:class="{ 'lists-moved' : newGroceryListModalShown}">

            <ul class="all-lists-wrapper">
                <li v-for="list in grocerylists" class="grocery-list grow"><router-link :to="{ name: 'grocery-lists', params: { id: list.id }}" >{{list.title}}</router-link></li>
            </ul>

        </div>
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
                this.searchOpen = !this.searchOpen;
            },

            newListModal() {
                this.newGroceryListModalShown = !this.newGroceryListModalShown;
            },

            hideNewGroceryListModal() {
                this.newGroceryListModalShown = false;
            },

            saveList() {
                GroceryLists.save(this.listTitle).then((response) => {
                    this.$router.push({ path: `/grocery-lists/${response.data.data.id}` });
                });
            }
        }
    }
</script>
