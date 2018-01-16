<?php

namespace App\Repositories;

use App\Entities\Department;
use App\Entities\ListableIngredient;
use Prettus\Repository\Eloquent\BaseRepository;

class ListableIngredientRepositoryEloquent extends BaseRepository implements ListableIngredientRepository
{
    public function create(array $attributes)
    {
        if (!array_get($attributes, 'department_id')) {
            $attributes['department_id'] = Department::default()->getKey();
        }

        return parent::create($attributes);
    }

    /**
     * @return string
     */
    public function model()
    {
        return ListableIngredient::class;
    }
}
