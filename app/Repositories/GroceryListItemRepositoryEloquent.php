<?php

namespace App\Repositories;

use App\Entities\GroceryListItem;
use App\Validators\GroceryListItemValidator;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class GroceryListItemRepositoryEloquent extends BaseRepository implements GroceryListItemRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GroceryListItem::class;
    }

    /**
     * @return string
     */
    public function presenter()
    {
//        return GroceryListItemPresenter::class;
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
