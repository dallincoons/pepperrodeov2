import GroceryLists from './components/GroceryLists.vue';
import GroceryList from './components/GroceryList.vue';
import GroceryListCreate from './components/GroceryListCreate.vue';
import RecipeCreate from './components/RecipeCreate.vue';
import Recipes from './components/Recipes.vue';
import Recipe from './components/Recipe.vue';
import Dashboard from './components/Dashboard';

let routes = [
    {
        'path' : '/',
        'component' : Dashboard,
    },
    {
        'path' : '/grocery-lists',
        'component': GroceryLists
    },
    {
        'path' : '/grocery-lists/create',
        'component': GroceryListCreate
    },
    {
        'path' : '/grocery-lists/:id',
        'components' : {
            default :  GroceryList,
        },
        'name' : 'grocery-lists',
    },
    {
        'path' : '/recipe/create',
        'component' : RecipeCreate,
        'name' : 'create-recipe',
    },
    {
        'path' : '/recipes',
        'component' : Recipes,
    },
    {
        'path' : '/recipe/:id',
        'components' : {
            default :  Recipe,
        },
        'name' : 'recipe',
    }
];
export default routes;
