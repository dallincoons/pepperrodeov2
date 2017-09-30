<template>
    <div class="container">
        <div class="container-heading"><h2>My Grocery Lists</h2>
            <div class="search-container">
                <input v-model="searchQuery" class="searchInput" @keyup.enter="searchGroceryLists"><button class="search-button" type="button" @click="searchGroceryLists" @keyup.enter="searchGroceryLists">

                <!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="20px" height="20px">
<path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" fill="#FFFFFF"/>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
</svg>
            </button>
            </div>
        </div>
        <div class="container-body">

            <ul class="list-container">
                <li v-for="list in grocerylists" class="grocery-list grow"><router-link :to="{ name: 'grocery-list', params: { id: list.id }}" >{{list.title}}</router-link></li>
            </ul>>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                grocerylists : [],
                searchQuery : ''
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
            }
        }
    }
</script>

<style>

    body {
        width: 100%;
        background: #fff4f0;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .container {
        width: 60%;
        background: #fff;
        display: flex;
        flex-direction: column;
        border-radius: 10px;
        -webkit-box-shadow: 0 0 15px 5px rgba(27,26,26,0.14);
        -moz-box-shadow: 0 0 15px 5px rgba(27,26,26,0.14);
        box-shadow: 0 0 15px 5px rgba(27,26,26,0.14);
        margin-bottom: 40px;
        margin-top: 50px;

    }

    .container-heading {
        background: #ff4b2e;
        margin: 0 -15px;
        border-radius: 10px 10px 0 0;
        color: #fff;
        padding: 0 0 0 2%;
        display: flex;
        justify-content: space-between;
    }

    .container-heading h2 {
        font-weight: 200;
        margin-top: 11px;
    }

    .container-body {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .list-container {
        width: 100%;
    }
    .grocery-list {
        width: 90%;
        padding: 1%;
        background: #ffffff;
        border-left: 7px solid #ff4b2e;
        border-top: 1px solid rgba(27,26,26,.1);
        border-radius: 5px;
        -webkit-box-shadow: 1px 3px 2px 1px rgba(27,26,26,0.1);
        -moz-box-shadow: 1px 3px 2px 1px rgba(27,26,26,0.1);
        box-shadow: 1px 3px 2px 1px rgba(27,26,26,0.1);
        font-size: 1.5em;
        margin: 2% 0;
        transition: border-left 1s;
    }

    .grocery-list a {
        color: #4f4f4f;
    }

    .grocery-list a:hover {
        color: #4f4f4f;
        text-decoration: none;
    }

    .grocery-list:hover {
        border-left: 7px solid #BF3822;
        transition: border-left 1s;
    }

    .search-container {
        align-self: center;
        margin-right: 2%;
        display: flex;
    }

    .searchInput {
        background: #BF3822;
        border: none;
        border-radius: 2px;
        font-size: 1.2em;
        -webkit-box-shadow: inset 2px 2px 15px 0px rgba(127,37,23,1);
        -moz-box-shadow: inset 2px 2px 15px 0px rgba(127,37,23,1);
        box-shadow: inset 2px 2px 15px 0px rgba(127,37,23,1);
        color: #ffffff;
        padding-left: 5px;
        opacity: .5;
        transition: opacity 2s;
    }

    .searchInput:focus {
        opacity: 1;
        transition: opacity 2s;
    }

    .search-button {
        background: #ff4b2e;
        border: none;
        border-radius: 2px;
        display: flex;
        padding: 5px;
        transition: background 2s;
    }

    .search-button:hover {
        background: #BF3822;
        transition: background 2s;
    }

    </style>
