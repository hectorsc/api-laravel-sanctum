<?php

namespace Tests\Unit;

use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class RatingTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_product_belongs_to_many_users()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        $user->rate($product, 5);
        // $this->assertInstanceOf('Illuminate\Database\Eloquent\');
        // // $this->assertInstanceOf();
      
    }
}
