<template>
    <div>
        <h1>Make Yo List</h1>
        <form v-on:submit.prevent>
            <input title="Grocery List Title" v-model="listTitle" @keyup.enter="saveTitle()">
            <button type="button" @click="saveTitle()">Save</button>
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
