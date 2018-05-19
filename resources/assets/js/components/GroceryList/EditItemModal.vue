<template>
    <modal @close="displayModal">

        <span class="close-modal" @click="displayModal" transition="modal">x</span>
        <h3 class="modal-heading">Edit Item</h3>
        <div class="modal-edit-section">
            <input class="modal-edit-input" :value="description" v-model="description">
            <select v-model="department" class="edit-dept-options">
                <option v-for="department in departments" :value="department.id">{{department.name}}</option>
            </select>
            <button class="modal-button" @click="updateItem">Save</button>
        </div>
        <div class="modal-edit-footer">
            <span class="modal-delete-img">
                <trash-can width="16" height="16"></trash-can>
            </span>
            <span class="modal-delete" @click="deleteItem">Delete Item</span>
        </div>
    </modal>
</template>

<script>
    import Modal from '../Modal.vue';
    import TrashCan from '../assets/trashcan.vue';

    export default {
        props : ['itemToUpdate', 'departments'],
        components : {
            'modal' : Modal,
            TrashCan
        },
        mounted() {
            this.department = this.itemToUpdate.department_id;
            this.description = this.itemToUpdate.quantity + ' ' + this.itemToUpdate.description;
        },
        data() {
            return {
                department : 0,
                description : ''
            }
        },
        methods : {
            displayModal() {
                this.$emit('close');
            },

            updateItem() {
                this.$emit('update', {
                    id : this.itemToUpdate.id,
                    description : this.description,
                    department_id : this.department
                });
            },

            deleteItem() {
                this.$emit('delete', {
                    id : this.itemToUpdate.id
                });
            }
        }
    }
</script>


