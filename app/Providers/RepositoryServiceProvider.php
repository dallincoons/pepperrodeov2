<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\GroceryListRepository::class, \App\Repositories\GroceryListRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\GroceryListItemRepository::class, \App\Repositories\GroceryListItemRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RecipeRepository::class, \App\Repositories\RecipeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RecipeRepository::class, \App\Repositories\RecipeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ListableIngredientRepository::class, \App\Repositories\ListableIngredientRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MealPlanningGroupRepository::class, \App\Repositories\MealPlanningGroupRepositoryEloquent::class);
    }
}
