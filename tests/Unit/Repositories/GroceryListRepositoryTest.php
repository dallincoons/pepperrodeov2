<?php

namespace Tests\Unit\Repositories;

use App\Entities\Department;
use App\Entities\GroceryList;
use App\Entities\GroceryListItem;
use App\Repositories\GroceryListRepository;
use App\Repositories\GroceryListRepositoryEloquent;
use Tests\TestCase;

class GroceryListRepositoryTest extends TestCase
{
    /**
     * @var GroceryListRepositoryEloquent
     */
    private $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = app(GroceryListRepository::class);
    }

    /** @test */
    public function uses_default_department_for_item_when_non_is_provided()
    {
        $this->repository->create(factory(GroceryList::class)->raw() + ['items' => [
            [
                'quantity' => 12,
                'description' => 'heyo'
            ]
        ]]);

        $this->assertNotNull(GroceryListItem::first()->department);
        $this->assertEquals(Department::default()->getKey(), GroceryListItem::first()->department->getKey());
    }
}
