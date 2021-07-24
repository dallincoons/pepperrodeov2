<?php

namespace Tests\Unit;

use Tests\TestCase;

class DuplicateItemMacroTest extends TestCase
{
    private $collection;

    public function setUp()
    {
        parent::setUp();

        $this->collection = collect([
            [
                'field1' => 'abc',
                'field2' => '111'
            ],
            [
                'field1' => 'ABC',
                'field2' => '222'
            ],
            [
                'field1' => 'DEF',
                'field2' => str_random()
            ],
        ]);
    }

    /** @test */
    public function it_finds_duplicate_items_in_collection()
    {
        $result = $this->collection->duplicates('field1');

        $this->assertCount(2, $result);

        $this->assertEquals(['111', '222'], $result->pluck('field2')->all());
    }
}
