<?php

use App\Entities\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            'Produce',
            'Meat',
            'Dairy',
            'Canned',
            'Dry Goods',
            'Frozen',
            'Deli',
            'Bakery',
            'Other',
            'Household'
        ];

        sort($departments);

        foreach ($departments as $department) {
            factory(Department::class)->create([
                'name' => $department
            ]);
        }
    }
}
