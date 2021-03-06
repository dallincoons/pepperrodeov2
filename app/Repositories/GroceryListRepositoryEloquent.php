<?php

namespace App\Repositories;

use App\Entities\GroceryList;
use App\Entities\GroceryListItem;
use App\Presenters\GroceryListPresenter;
use App\User;
use Illuminate\Foundation\Application;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Validator\Exceptions\ValidatorException;

class GroceryListRepositoryEloquent extends BaseRepository implements GroceryListRepository
{
    /**
     * @var GroceryListItemRepositoryEloquent
     */
    private $groceryListItemRepository;

    public function __construct(Application $app, GroceryListItemRepository $groceryListItemRepository)
    {
        parent::__construct($app);

        $this->groceryListItemRepository = $groceryListItemRepository;
    }

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
            $this->groceryListItemRepository->create([
                'grocery_list_id' => array_get($grocerylist, 'data.id')
            ] + $item);
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
     * @return string
     */
    public function presenter()
    {
        return GroceryListPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
