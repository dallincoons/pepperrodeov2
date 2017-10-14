<?php

namespace Tests\Feature\Departments;

use App\Entities\Department;
use Tests\TestCase;

/**
 * @group feature-tests
 */
class RetrieveDepartmentsTest extends TestCase
{
    /** @test */
    public function it_retrieves_all_departments()
    {
        factory(Department::class, 2)->create();

        $response = $this->get('/api/v1/departments');

        $this->assertEquals(2, count($response->decodeResponseJson()));
    }
}
