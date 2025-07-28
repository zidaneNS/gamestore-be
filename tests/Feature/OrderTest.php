<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_checkout()
    {
        $user = User::find(1);

        $product = Product::find(1);

        $repsonse = $this->actingAs($user)->get('api/checkout/' . $product->id);

        $repsonse
            ->assertStatus(201)
            ->assertJsonStructure([
                'snapToken'
            ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'status' => 'pending'
        ]);
    }
}
