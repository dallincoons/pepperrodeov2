import GroceryLists from './components/GroceryLists.vue';
import GroceryList from './components/GroceryList.vue';
import GroceryListCreate from './components/GroceryListCreate.vue';
import GroceryListNavigation from './components/GroceryListNavigation.vue';

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
        'components' : {
            default :  GroceryList,
            navigation : GroceryListNavigation
        },
        'name' : 'grocery-list',
    }
];
export default routes;
