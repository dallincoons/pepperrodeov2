<?php

namespace Tests\Feature\Recipe;

use App\Entities\Recipe;
use Tests\TestCase;

class DeleteRecipeTest extends TestCase
{
    /** @test */
    public function it_deletes_a_recipe()
    {
        $recipe = factory(Recipe::class)->create();

        $this->assertEquals(1, Recipe::count());

        $this->delete($this->api('recipes/' . $recipe->getKey()));

        $this->assertEquals(0, Recipe::count());
    }
}
