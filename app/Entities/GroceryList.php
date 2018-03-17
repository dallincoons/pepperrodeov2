<?php

namespace App\Entities;

use App\Entities\Behavior\OrderByLatest;
use App\Repositories\GroceryListItemRepository;
use App\Services\GroceryItemCombine;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class GroceryList extends Model implements Transformable
{
    use TransformableTrait, Searchable, OrderByLatest;

    protected $fillable = [
        'title',
        'user_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function items()
    {
        return $this->hasMany(GroceryListItem::class);
    }

    public function itemGroups()
    {
        return $this->hasMany(GroceryListItemGroup::class);
    }

    public function getRecipesAttribute()
    {
        $recipeIds = $this->itemGroups()
            ->pluck('recipe_id')
            ->unique();

        return Recipe::whereIn('id', $recipeIds)->get();
    }

    public function getUniqueRecipeCountAttribute()
    {
        return array_count_values($this->itemGroups()
            ->pluck('recipe_id')->all());
    }

    /**
     * @param Recipe $recipe
     */
    public function addRecipe(Recipe $recipe)
    {
        $itemRepository = app(GroceryListItemRepository::class);

        $group = GroceryListItemGroup::create([
            'grocery_list_id' => $this->getKey(),
            'recipe_id' => $recipe->getKey()
        ]);

        foreach ($recipe->listableIngredients as $ingredients) {
            $itemRepository->create(
                $this->translateIngredient($ingredients, $recipe)
                 + ['grocery_list_id' => $this->getKey(), 'grocery_list_group_id' => $group->getKey()]
            );
        }
    }

    public function getCombinedItemsAttribute()
    {
        return $this->getCombinedItems();
    }

    public function getCombinedItems()
    {
        return app(GroceryItemCombine::class)->combine($this)->load('department');
    }

    public function translateIngredient(ListableIngredient $ingredient, Recipe $recipe)
    {
        return [
            'description'   => $ingredient->description,
            'quantity'      => $ingredient->quantity,
            'department_id' => $ingredient->department_id,
            'recipe_id'     => $recipe->getKey()
        ];
    }
}
