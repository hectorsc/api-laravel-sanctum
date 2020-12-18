<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Product;
use App\User;
use Laravel\Sanctum\Sanctum;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    // PRUEBAS PARA PROBAR LOS ENDPOINTS DE PRODUCTS
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
        factory(Product::class, 5)->create();

        $response = $this->getJson('/api/products');

        $response->assertSuccessful();
        // $response->assertHeader('content-type', 'application/json');
        $response->assertJsonCount(5, 'data');
    }

    public function test_create_new_product()
    {
        $data = [
            'name' => 'Hola',
            'price' => 1000,
        ];
        $response = $this->postJson('/api/products', $data);

        // recibir mensajes del response por consola
        $response->dump();

        $response->assertSuccessful();
        // $response->assertHeader('content-type', 'application/json');
        $this->assertDatabaseHas('products', $data);
    }

    public function test_update_product()
    {
        $product = factory(Product::class)->create();
        $data = [
            'name' => 'Update Product',
            'price' => 20000,
        ];

        $response = $this->patchJson("/api/products/{$product->getKey()}", $data);
        $response->assertSuccessful();
        // $response->assertHeader('content-type', 'application/json');

    }

    public function test_show_product()
    {
        $product = factory(Product::class)->create();

        $response = $this->getJson("/api/products/{$product->getKey()}");
        $response->assertSuccessful();
        // $response->assertHeader('content-type', 'application/json');
    }

    public function test_delete_product()
    {
        $product = factory(Product::class)->create();

        $response = $this->deleteJson("/api/products/{$product->getKey()}");

        $response->assertSuccessful();
        // $response->assertHeader('content-type', 'application/json');
        $this->assertDeleted($product);
    }
}
