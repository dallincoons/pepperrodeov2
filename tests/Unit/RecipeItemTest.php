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
}
