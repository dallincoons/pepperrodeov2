<template>
    <div class="container">
        <h2 class="container-heading">Name Your List</h2>
        <form v-on:submit.prevent class="create-form">
            <input title="Grocery List Title" v-model="listTitle" @keyup.enter="saveTitle()" class="title-input" placeholder="List Title">
            <button type="button" @click="saveTitle()" class="save-button">Save</button>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                listTitle : '',
            }
        },
        methods : {
            saveTitle() {
                axios.post('/api/v1/grocery-list', {title : this.listTitle}).then((response) => {
                    this.$router.push({ path: `/grocery-list/${response.data.data.id}` });
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
    }

    .title-input {
        width: 80%;
        border: 1px solid #4f4f4f;
        padding: .5%;
        font-size: 1.5em;
        margin-top: 2%;
    }

    .save-button {
        background: #ff4b2e;
        color: #FFFFFF;
        border: 1px solid #ff4b2e;
        padding: .5%;
        font-size: 1.5em;
        transition: background 2s;
    }

    .save-button:hover {
        border: 1px solid #BF3822;
        background: #BF3822;
        transition: background 2s;
    }
</style>
