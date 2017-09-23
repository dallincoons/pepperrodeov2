<template>
    <div class="add-item-wrapper">
        <div class="add-item">
            <input title="description" v-model="description" @keyup.enter="saveItem" placeholder="+ Add an Item">
        </div>
        <select v-model="department" class="dept-options">
            <option value="" disabled selected style="display: none;">Department</option>
            <option v-for="department in departments" :value="department.id">{{department.name}}</option>
        </select>
        <button @click="saveItem" @enter="saveItem" class="save"><span>Save Item</span></button>
    </div>
</template>

<script>
    export default {
        props : ['departments'],
        data(){
            return {
                description : '',
                department  : '',
                listId : ''
            }
        },

        mounted() {
            this.listId = this.$route.params.id;
        },

        methods : {
            saveItem() {
                let itemDetails = {
                    grocery_list_id : this.listId,
                    description     : this.description,
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
