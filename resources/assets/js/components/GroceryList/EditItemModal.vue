<template>
    <modal @close="displayModal">
        <div class="wrapper-modal"
             role="dialog"
             aria-labelledby="modalTitle"
             aria-describedby="modalDescription"
        >
            <div :class="modalClass" class="modal-container" @click.stop>
                <button type="button" class="close-modal" @click="displayModal" aria-label="Close modal"><xIcon></xIcon></button>
                <h4 class="modal-heading" id="modalTitle">Edit Item</h4>
                <div class="modal-edit-section">
                    <input class="modal-edit-input" v-model="description" id="modalDescription">
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
            </div>
        </div>
    </modal>
</template>

<script>
    import Modal from '../Modal.vue';
    import TrashCan from '../assets/trashcan.vue';
    import xIcon from '../assets/x-icon.vue';

    export default {
        props : ['itemToUpdate', 'departments'],
        components : {
            'modal' : Modal,
            TrashCan,
            xIcon
        },
        mounted() {
            this.department = this.itemToUpdate.department_id;
            this.description = this.itemToUpdate.quantity + ' ' + this.itemToUpdate.description;
        },
        data() {
            return {
                department : 0,
                description : '',
            }
        },
        methods : {
            displayModal() {
                this.$emit('close');
            },

            updateItem() {
                this.$emit('update', {
                    id : this.itemToUpdate.id,
                    new_description : this.description,
                    description : this.itemToUpdate.description,
                    department_id : this.department
                });
            },

            deleteItem() {
                this.$emit('delete', {
                    ids: this.itemToUpdate.ids,
                });
            }
        }
    }
</script>


