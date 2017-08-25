<?php

namespace App\Repositories;

use App\Entities\GroceryList;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Validator\Exceptions\ValidatorException;

class GroceryListRepositoryEloquent extends BaseRepository implements GroceryListRepository
{
    /**
     * @throws ValidatorException
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes)
    {
        $grocerylist = parent::create($attributes);

        $items = array_get($attributes, 'items') ?: [];

        foreach($items as $item){
            $grocerylist->items()->create($item);
        }

        return $grocerylist;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GroceryList::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
