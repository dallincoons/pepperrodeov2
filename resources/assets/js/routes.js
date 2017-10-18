import GroceryLists from './components/GroceryLists.vue';
import GroceryList from './components/GroceryList.vue';
import GroceryListCreate from './components/GroceryListCreate.vue';
import RecipeCreate from './components/RecipeCreate.vue';


let routes = [
    {
        'path' : '/',
        'component' : GroceryLists
    },
    {
        'path' : '/grocery-lists',
        'component': GroceryLists
    },
    {
        'path' : '/grocery-list/create',
        'component': GroceryListCreate
    },
    {
        'path' : '/grocery-list/:id',
        'components' : {
            default :  GroceryList,
        },
        'name' : 'grocery-list',
    },
    {
        'path' : '/recipe/create',
        'component' : RecipeCreate,
    }
];
export default routes;
