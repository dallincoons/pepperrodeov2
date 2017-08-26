import VueRouter from 'vue-router';

import GroceryLists from './components/GroceryLists.vue';
import GroceryList from './components/GroceryList.vue';
import GroceryListCreate from './components/GroceryListCreate.vue';

let routes = [
    {
        'path' : '/grocery-lists',
        'component' : GroceryLists
    },
    {
        'path' : '/grocery-list/create',
        'component': GroceryListCreate
    },
    {
        'path' : '/grocery-list/:id',
        'component' : GroceryList,
        'name' : 'grocery-list',
    }
];

export default new VueRouter({
    routes
});
