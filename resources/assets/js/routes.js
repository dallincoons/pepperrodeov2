import VueRouter from 'vue-router';

import GroceryLists from './components/GroceryLists.vue';
import GroceryList from './components/GroceryList.vue';

let routes = [
    {
        'path' : '/grocery-lists',
        'component' : GroceryLists
    },
    {
        'path' : '/grocery-list/:id',
        'component' : GroceryList
    }
];

export default new VueRouter({
    routes
});
