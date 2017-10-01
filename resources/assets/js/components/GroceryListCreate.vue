<template>
    <div class="container">
        <h2 class="container-heading">Name Your List</h2>
        <div class="container-create">
            <form v-on:submit.prevent class="create-form">
                <input title="Grocery List Title" v-model="listTitle" @keyup.enter="saveTitle()" class="title-input" placeholder="List Title">
                <button type="button" @click="saveTitle()" class="save-button">Save</button>
            </form>
        </div>

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


