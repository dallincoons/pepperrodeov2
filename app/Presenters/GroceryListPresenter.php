<?php

namespace App\Presenters;

use App\Transformers\GroceryListTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class GroceryListPresenter
 *
 * @package namespace App\Presenters;
 */
class GroceryListPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new GroceryListTransformer();
    }
}
