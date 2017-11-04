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

    /**
     * @param Recipe $recipe
     */
    public function addRecipe(Recipe $recipe)
    {
        $itemRepository = app(GroceryListItemRepository::class);
        foreach ($recipe->listableIngredients as $ingredients) {
            $itemRepository->create(
                $this->translateIngredient($ingredients, $recipe)
                 + ['grocery_list_id' => $this->getKey()]
            );
        }
    }

    public function getCombinedItemsAttribute()
    {
        return $this->getCombinedItems();
    }

    public function getCombinedItems()
    {
        $items = app(GroceryItemCombine::class)->combine($this);

        return $items;
    }

    public function translateIngredient(ListableIngredient $ingredient, Recipe $recipe)
    {
        return [
            'description' => $ingredient->description,
            'quantity'    => $ingredient->quantity,
            'recipe_id'   => $recipe->getKey()
        ];
    }
}
