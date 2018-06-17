<?php

namespace App\Repositories;

use App\Entities\Behavior\DescriptionParsers\DescriptionParserFactory;
use App\Entities\Department;
use App\Entities\GroceryList;
use App\Entities\GroceryListItem;
use App\Validators\GroceryListItemValidator;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class GroceryListItemRepositoryEloquent extends BaseRepository implements GroceryListItemRepository
{
    public function create(array $attributes)
    {
        if (!array_get($attributes, 'department_id')) {
            $attributes['department_id'] = Department::default()->getKey();
        }

        $parser = DescriptionParserFactory::make($attributes['description']);

        $attributes['description'] = $parser->getDescription();
        $attributes['quantity'] = $parser->getQuantity();

        if (count($duplicates = $this->getDuplicates($attributes))) {
            $parentItem = $this->insertDuplicate($attributes, $duplicates);
            $attributes['parent_id'] = $parentItem->getKey();
        }

        return parent::create($attributes);
    }

    private function getDuplicates(array $attributes)
    {
        return GroceryListItem::where(['grocery_list_id' => $attributes['grocery_list_id'], 'description' => $attributes['description'], 'is_combination' => 0])->get();
    }

    private function insertDuplicate($attributes, $duplicates)
    {
        if(!is_null($parentId = $duplicates->first()->parent_id)) {
            $combinationItem = GroceryListItem::find($parentId);
        } else {
            $attributes['is_combination'] = 1;

            $combinationItem = parent::create($attributes);

            foreach ($duplicates as $duplicate) {
                $duplicate->parent_id = $combinationItem->getKey();
                parent::update($duplicate->toArray(), $duplicate->getKey());
            }
        }
        $combinationItem->quantity = $duplicates->sum('quantity') + $attributes['quantity'];
        parent::update($combinationItem->toArray(), $combinationItem->getKey());

        return $combinationItem;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GroceryListItem::class;
    }

    public function validator()
    {
        return GroceryListItemValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
