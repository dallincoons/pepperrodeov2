<?php

namespace App\Repositories;

use App\Entities\GroceryList;
use App\Entities\GroceryListItem;
use App\MealPlanGroup;
use App\Presenters\GroceryListPresenter;
use App\User;
use Illuminate\Foundation\Application;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Validator\Exceptions\ValidatorException;

class MealPlanningGroupRepositoryEloquent extends BaseRepository implements MealPlanningGroupRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MealPlanGroup::class;
    }

    /**
     * @return string
     */
    public function presenter()
    {
//        return GroceryListPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
