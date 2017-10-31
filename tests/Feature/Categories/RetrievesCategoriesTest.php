<?php

namespace Tests\Feature\Categories;

use App\Category;
use App\User;
use Tests\TestCase;

class RetrievesCategoriesTest extends TestCase
{
    /** @test */
    public function it_gets_a_list_of_categories_belonging_user()
    {
        $this->withoutExceptionHandling();

        factory(Category::class, 2)->create();
        factory(Category::class, 1)->create(['user_id' => factory(User::class)->create()->getKey()]);

        $response = $this->get('/api/v1/categories');

        $response->assertSuccessful();
        $this->assertCount(2, $response->decodeResponseJson());
    }
}
