<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinkedRecipe extends Model
{
    protected $fillable = [
        'source_recipe_id', 'destination_recipe_id',
    ];
}
