<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Category;
use App\User;
use Laravel\Sanctum\Sanctum;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    // PRUEBAS PARA PROBAR LOS ENDPOINTS DE CATEGORIES
    protected function setUp(): void
    {
        parent::setUp();
        
        // colocamos esto en setUp para que se ejecute en todos los test
        Sanctum::actingAs(
            factory(User::class)->create(),
        );
    }

    public function test_index()
    {
        factory(Category::class, 5)->create();

        $response = $this->getJson('/api/categories');

        $response->assertSuccessful();
        // $response->assertHeader('content-type', 'application/json');
        $response->assertJsonCount(5);
    }

    public function test_create_new_category()
    {
        $data = [
            'name' => 'Hola'
        ];
        $response = $this->postJson('/api/categories', $data);

        $response->assertSuccessful();
        // $response->assertHeader('content-type', 'application/json');
        $this->assertDatabaseHas('categories', $data);
    }

    public function test_update_category()
    {
        $category = factory(Category::class)->create();
        $data = [
            'name' => 'Update category',
        ];

        $response = $this->patchJson("/api/categories/{$category->getKey()}", $data);
        $response->assertSuccessful();
        // $response->assertHeader('content-type', 'application/json');

    }

    public function test_show_category()
    {
        $category = factory(Category::class)->create();

        $response = $this->getJson("/api/categories/{$category->getKey()}");
        $response->assertSuccessful();
        // $response->assertHeader('content-type', 'application/json');
    }

    public function test_delete_category()
    {
        $category = factory(Category::class)->create();

        $response = $this->deleteJson("/api/categories/{$category->getKey()}");

        $response->assertSuccessful();
        // $response->assertHeader('content-type', 'application/json');
        $this->assertDeleted($category);
    }
}
