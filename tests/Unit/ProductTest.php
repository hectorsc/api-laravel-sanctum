<?php

namespace Tests\Unit;

use App\Category;
use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use PHPUnit\Framework\TestCase;
// al crear el test me puso el phpunit este que me peto
//hay que usar este
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_product_belongs_to_category()
    {
        $category = factory(Category::class)->create();
        $product = factory(Product::class)->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $product->category);
        
    }

    // public function test_a_product_belongs_to_user()
    // {
    //     $user = User::all()->first();
    //     // pillaremos el usuario
    //     // algo asi será
    //     $product = factory(Product::class)->create(['user_id' => $user->id]);
    //     $this->assertInstanceOf(User::class, $product->products);
    // }
}
