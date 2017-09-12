<template>
    <div class="edit-item" v-show="listId">
        <span>Update</span>
        <span @click="deleteItem()">Delete</span>
        <div class="nav-line"></div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                listId : ''
            }
        },
        mounted() {
            EventBus.$on('grocerylist.update.show', (params) => {
                this.listId = params.id;
            });
        },
        methods : {
            deleteItem() {
                EventBus.$emit('deleteItem', {id : this.listId});
            }
        }
    }
</script>
