<?php

namespace Tests\Unit;

use App\Entities\Ingredient;
use Tests\TestCase;

class IngredientTest extends TestCase
{
    /** @test */
    public function it_makes_ingredient_listable()
    {
        $ingredient = factory(Ingredient::class)->create();

        $this->assertSame(0, $ingredient->listable);

        $ingredient->toggleListable()->save();

        $this->assertEquals(1, $ingredient->fresh()->listable);
    }

    /**
     * @test
     *
     * @dataProvider recipeQtyProvider
     */
    public function it_handles_fractions_to_be_set_in_quantity_field($fraction, $expected)
    {
        $item = factory(Ingredient::class)->create([
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
