<?php

namespace Tests\Unit\Repositories;

use App\Entities\GroceryList;
use App\Entities\GroceryListItem;
use App\Repositories\GroceryListItemRepository;
use Tests\TestCase;

class GroceryListItemRepositoryTest extends TestCase
{
    /**
     * @var GroceryListItemRepository
     */
    private $repository;

    public function setUp()
    {
        parent::setUp();

        $this->repository = app(GroceryListItemRepository::class);
    }

    /** @test */
    public function it_creates_combined_item()
    {
        $grocery = factory(GroceryList::class)->create();
        $rawItem = factory(GroceryListItem::class)->raw([
            'grocery_list_id' => $grocery->getKey(),
            'description' => '3 abc',
        ]);
        $item = $this->repository->create($rawItem);
        $item2 = $this->repository->create($rawItem);
        $item3 = $this->repository->create($rawItem);

        $combination = GroceryListItem::where('is_combination', 1)->first();

        $this->assertCount(4, $grocery->items);
        $this->assertEquals(2, $item->fresh()->parent_id);
        $this->assertEquals(2, $item2->parent_id);
        $this->assertEquals(2, $item3->parent_id);
        $this->assertEquals(9, $combination->quantity);
    }
}
