<?php

use App\Entities\Department;
use Illuminate\Database\Migrations\Migration;

class PopulatesDefaultDepartment extends Migration
{
    public function up()
    {
        Department::create([
            'name' => Department::DEFAULT_DEPT_NAME
        ]);
    }

    public function down()
    {
//        Department::where('name', Department::DEFAULT_DEPT_NAME)->delete();
    }
}
