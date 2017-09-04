<?php

namespace App\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class GroceryListItemValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_UPDATE => [
            'description' => 'string'
        ]
    ];
}
