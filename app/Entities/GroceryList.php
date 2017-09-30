<?php

namespace App\Entities;

use App\Entities\GroceryListItem;
use App\Scopes\OrderByLatest;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class GroceryList extends Model implements Transformable
{
    use TransformableTrait, Searchable;

    protected $fillable = [
        'title', 'user_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderByLatest);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function items()
    {
        return $this->hasMany(GroceryListItem::class);
    }

}
