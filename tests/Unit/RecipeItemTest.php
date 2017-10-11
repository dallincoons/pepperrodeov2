<?php

namespace Tests\Unit;

use App\Entities\RecipeItem;
use Tests\TestCase;

class RecipeItemTest extends TestCase
{
    /** @test */
    public function it_makes_recipe_listable()
    {
        $recipe = factory(RecipeItem::class)->create();

        $this->assertSame(0, $recipe->listable);

        $recipe->toggleListable()->save();

        $this->assertEquals(1, $recipe->fresh()->listable);
    }

    /**
     * @test
     *
     * @dataProvider recipeQtyProvider
     */
    public function it_handles_fractions_to_be_set_in_quantity_field($fraction, $expected)
    {
        $item = factory(RecipeItem::class)->create([
            'quantity' => $fraction
        ]);

        $this->assertEquals($expected, $item->quantity);
    }

    public function recipeQtyProvider()
    {
        return [
            ['1/2', '1/2'],
            [1, '1'],
            ['1', '1'],
            ['2/4', '1/2'],
            ['2/5', '2/5']
        ];
    }
}
