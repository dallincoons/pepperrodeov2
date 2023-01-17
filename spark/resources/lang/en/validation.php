<?php

use Illuminate\Support\Str;

return [
    'eligibility' => 'You are not eligible for this plan based on your current number of '.Str::plural(Spark::teamString()).' / '.Spark::teamString().' members.'
];
