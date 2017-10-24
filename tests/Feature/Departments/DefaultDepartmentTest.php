<?php

namespace Tests\Feature\Departments;

use App\Entities\Department;
use Tests\TestCase;

class DefaultDepartmentTest extends TestCase
{
    /** @test */
    public function migration_populates_default_department()
    {
        $this->assertEquals(1, Department::count());
        $this->assertEquals(Department::DEFAULT_DEPT_NAME, Department::first()->name);
    }

    /** @test */
    public function retrieve_default_department()
    {
        $this->assertEquals(Department::DEFAULT_DEPT_NAME, Department::default()->name);
    }
}
