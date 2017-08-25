<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\GroceryList;

/**
 * Class GroceryListTransformer
 * @package namespace App\Transformers;
 */
class GroceryListTransformer extends TransformerAbstract
{

    /**
     * Transform the \GroceryList entity
     * @param \GroceryList $model
     *
     * @return array
     */
    public function transform(GroceryList $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
