<template>
    <div>
        <h1>Make Yo List</h1>
        <form>
            <input title="Grocery List Title" v-model="listTitle">
            <input type="number" title="Quantity" v-model="quantity">
            <input title="Item" v-model="description">
            <button type="button" @click="saveList">Save</button>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                listTitle : '',
                quantity : '',
                description : ''
            }
        },
        methods : {
            saveList() {
                axios.post('/api/v1/grocery-list', {title : this.listTitle, items:[
                    {quantity : this.quantity, description : this.description}
                ]}).then((response) => {
                    console.log(response);
                });
            }
        }
    }
</script>
