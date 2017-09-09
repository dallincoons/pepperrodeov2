<template>
    <div class="container">
        <div class="container-heading"><h2>My Grocery Lists</h2></div>
        <div class="container-body">
            <ul class="list-container">
                <li v-for="list in grocerylists" class="grocery-list"><router-link :to="{ name: 'grocery-list', params: { id: list.id }}" >{{list.title}}</router-link></li>
            </ul>>
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
                this.grocerylists = response.data.data;
            });
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

    }

    .container-heading {
        background: #ff4b2e;
        margin: 0 -15px;
        border-radius: 10px 10px 0 0;
        color: #fff;
        padding: 0 0 0 2%;
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
    }

    .grocery-list a {
        color: #4f4f4f;
        transition: font-size 3s;
    }

    .grocery-list a:hover {
        color: #4f4f4f;
        text-decoration: none;
        font-size: 1.1em;
        transition: font-size 3s;
    }

    </style>
