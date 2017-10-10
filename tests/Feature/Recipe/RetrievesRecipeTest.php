<?php

namespace Tests\Feature\Recipe;

use App\Entities\Recipe;
use Tests\TestCase;

class RetrievesRecipeTest extends TestCase
{
    /** @test */
    public function it_retrieves_all_recipes()
    {
        factory(Recipe::class, 2)->create();

        $response = $this->get($this->api('recipes'));

        $response->assertSuccessful();
        $this->assertCount(2, $response->decodeResponseJson());
    }
}
