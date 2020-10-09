<template>
<div class="add-item-wrapper">
        <div class="add-item">
            <input class="list-add-item-input" title="description" v-model="description" @keyup.enter="saveItem" placeholder="Item">
        </div>
        <select v-model="department" class="dept-options">
            <option value="" disabled selected style="display: none;">Department</option>
            <option v-for="department in departments" :value="department.id">{{department.name}}</option>
        </select>
        <button @click="saveItem" @enter="saveItem" class="add-item-save">Add Item</button>
    </div>
</div>
</template>

<script>
    export default {
        props : ['departments'],
        data(){
            return {
                description : '',
                department  : '',
                listId : '',
            }
        },

        mounted() {
            this.listId = this.$route.params.id;
        },

        methods : {
            saveItem() {
                let itemDetails = {
                    grocery_list_id : this.listId,
                    magic_description : this.description,
                    department_id   : this.department
                };
                axios.post('/api/v1/grocery-list-item', itemDetails).then((response) => {
                    this.$emit('updated');
                    this.clear();
                })
            },

            clear() {
                this.description = '';
                this.department  = '';
            },
        }
    }
</script>
