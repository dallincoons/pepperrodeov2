import VueRouter from 'vue-router';

import GroceryLists from './components/GroceryLists.vue';

let routes = [
    {
        'path' : '/grocery-lists',
        'component' : GroceryLists
    }
];

export default new VueRouter({
    routes
});
