<?php

namespace Tests\Unit;

use App\Entities\Department;
use App\Entities\Ingredient;
use Tests\TestCase;

class IngredientTest extends TestCase
{
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

    /**
     * @test
     */
    public function an_ingredient_can_have_a_department()
    {
        $item = factory(Ingredient::class)->create();

        $this->assertInstanceOf(Department::class, $item->department);
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
