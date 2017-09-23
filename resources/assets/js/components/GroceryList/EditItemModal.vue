<template>
    <modal @close="displayModal">

        <span class="close-modal" @click="displayModal" transition="modal">x</span>
        <h3 class="modal-header">Edit Item</h3>
        <div class="modal-edit-section">
            <input class="modal-edit-input" :value="itemToUpdate.description" v-model="itemToUpdate.description">
            <select v-model="itemToUpdate.department_id" class="dept-options">
                <option v-for="department in departments" :value="department.id">{{department.name}}</option>
            </select>
            <button class="modal-button" @click="updateItem">Save</button>
        </div>
        <div class="modal-edit-footer">
            <trash-can></trash-can>
            <span class="modal-delete" @click="deleteItem">Delete Item</span>
        </div>
        <div class="modal-line"></div>
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
        },
        data() {
            return {
                department : 0
            }
        },
        methods : {
            displayModal() {
                this.$emit('close');
            },

            updateItem() {
                this.$emit('update', this.itemToUpdate);
            },

            deleteItem() {
                this.$emit('delete', this.itemToUpdate);
            }
        }
    }
</script>

<style>
    .modal-line {
        height: 5px;
        background-color: #ff4b2e;
        border-radius: 0 0 5px 5px;
        position: absolute;
        bottom: 0;
        width: 100%;

    }

    .modal-header {
        margin-top: 0;
        color: #4f4f4f;
        text-align: center;
        font-weight: 300;
    }

    .modal-edit-section {
        display: flex;
        flex-direction: column;
        justify-content: center;
        margin: 15px;
    }

    .modal-button {
        background: #ff4b2e;
        color: #FFFFFF;
        margin: 15px 0;
        border: 0;
        border-radius: 5px;
        padding: 5px 20px;
        font-weight: 700;
        font-size: 1.2em;
    }

    .modal-button:hover {
        background: #BF3822;
        transition: background 2s;
    }

    .modal-edit-input {
        width: 100%;
        background: #ebebeb;
        border: none;
        font-size: 1.2em;
        padding: 5px 20px;
    }

    .modal-edit-footer {
        align-self: flex-end;
        text-align: right;
        color: #ff4b2e;
        padding: 2px;
        margin-left: 15px;
    }

    .modal-edit-footer:hover {
        cursor: pointer;
    }

    .modal-delete {
        margin: 0 15px 0 2px;
    }
    .close-modal {
        position: absolute;
        right: 0;
        top: 0;
        font-weight: 700;
        font-size: 1.2em;
        margin-right: 5px;
    }

    .close-modal:hover {
        cursor: pointer;
    }
</style>
