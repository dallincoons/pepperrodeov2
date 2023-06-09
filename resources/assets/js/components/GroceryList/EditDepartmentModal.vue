<template>
    <modal @close="displayModal">
        <div class="wrapper-modal"
             role="dialog"
             aria-labelledby="modalTitle"
             aria-describedby="modalDescription"
        >
            <div :class="modalClass" class="modal-container" @click.stop>
                <button type="button" class="close-modal" @click="displayModal" aria-label="Close modal"><xIcon></xIcon></button>
                <h4 class="modal-heading" id="modalTitle">Edit {{departmentName}}</h4>
                <div class="modal-edit-footer">
                    <span class="modal-delete-img">
                        <trash-can width="16" height="16"></trash-can>
                    </span>
                    <span class="modal-delete" @click="deleteCategory">Delete</span>
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
        props : ['departmentId', 'departmentName'],
        components : {
            'modal' : Modal,
            TrashCan,
            xIcon
        },
        mounted() {
        },
        data() {
            return {
            }
        },
        methods : {
            displayModal() {
                this.$emit('close');
            },

            deleteCategory() {
                this.$emit('delete', {
                    id: this.$props.departmentId,
                });
            }
        }
    }
</script>


