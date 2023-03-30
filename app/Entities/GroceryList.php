<?php

namespace App\Entities;

use App\Entities\Behavior\OrderByLatest;
use App\Features\GroceryList\GroceryListBuilder;
use App\Features\MealPlanToList\ListFromMealPlanBuilder;
use App\Repositories\GroceryListItemRepository;
use App\Transformers\GroceryListRecipe;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class GroceryList extends Model implements Transformable
{
    use TransformableTrait, Searchable, OrderByLatest;

    protected $fillable = [
        'title',
        'user_id',
        'start_date',
        'end_date',
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
        $groceryListItems = GroceryListItemGroup::where('grocery_list_id', $this->getKey())->with('category')->with('recipe')->get();

        return $groceryListItems->map(function($item) {
            return new GroceryListRecipe($item->recipe_id, $item->recipe->title, $item->category_id, $item->category->title);
        });
    }

    public function getUniqueRecipeCountAttribute()
    {
        return array_count_values($this->itemGroups()
            ->pluck('recipe_id')->filter()->all());
    }

    /**
     * @param Recipe $recipe
     */
    public function addRecipe(Recipe $recipe, $categoryID = null)
    {
		$builder = new GroceryListBuilder($this);

		$builder->addRecipe($recipe, $categoryID);
    }

    public function removeRecipe(Recipe $recipe)
    {
        $group = $this->itemGroups()->where('recipe_id', $recipe->getKey())->first();

        $this->items()->where('grocery_list_group_id', $group->getKey())->delete();
        $group->delete();
    }

    public function getCombinedItemsAttribute()
    {
        return $this->getCombinedItems()->map(function($item) {
            return $item->toArray();
        });
    }

    public function getCombinedItems()
    {
        return $this->items()->with('department')
        ->get()
        ->toBase()
        ->groupBy(function($item) {
            return strtolower($item->description);
        })->map(function($item) {
            return new CompositeItem($item);
        });
    }
}
