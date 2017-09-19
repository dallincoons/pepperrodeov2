<template>
    <div class="edit-item" v-show="itemId">
        <span @click="showUpdateItem">Update</span>
        <span @click="deleteItem()">Delete</span>
        <div class="nav-line"></div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                itemId : '',
                itemDescription : '',
                itemDepartment : ''
            }
        },
        mounted() {
            EventBus.$on('grocerylist.update.show', (params) => {
                this.itemId = params.item.id;
                this.itemDescription = params.item.description;
                this.itemDepartment = params.item.department;
            });
        },
        methods : {
            deleteItem() {
                EventBus.$emit('deleteItem', {id : this.itemId});
            },
            showUpdateItem() {
                swal({
                        title: "An input!",
                        text: "Write something interesting:",
                        type: "input",
                        showCancelButton: true,
                        closeOnConfirm: true,
                        animation: "slide-from-top",
                        inputPlaceholder: this.itemDescription
                    },
                    (inputValue) => {
                        if (inputValue === false) return false;

                        if (inputValue === "") {
                            swal.showInputError("You need to write something!");
                            return false
                        }

                        this.updateItem(inputValue);

                    });
            },
            updateItem(inputValue) {
                EventBus.$emit('updateItem', {id : this.itemId, description : inputValue});
                this.itemId = '';
            },

        }
    }
</script>
