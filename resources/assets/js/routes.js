import GroceryLists from './components/GroceryLists.vue';
import GroceryList from './components/GroceryList.vue';
import GroceryListCreate from './components/GroceryListCreate.vue';
import RecipeCreate from './components/RecipeCreate.vue';
import Recipes from './components/Recipes.vue';
import Recipe from './components/Recipe.vue';

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
