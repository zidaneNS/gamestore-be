<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertJson;

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
    
    public function test_can_get_all_orders()
    {
        $user = User::find(1);
        
        $product = Product::find(1);
    
        $this->actingAs($user)->get('api/checkout/' . $product->id);

        $response = $this->actingAs($user)->get('api/orders');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'role'
                    ],
                    'product' => [
                        'id',
                        'amount',
                        'price',
                        'img_url',
                        'game' => [
                            'id',
                            'title',
                            'currency_name'
                        ]
                    ],
                    'status'
                ]
            ]);
    }

    public function test_get_orders_by_user()
    {
        $user = User::factory()->create(['role' => 'user']);

        $product = Product::find(1);

        $this->actingAs($user)->get('api/checkout/' . $product->id);

        $response = $this->actingAs($user)->get('api/orders/user');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'product' => [
                        'id',
                        'amount',
                        'price',
                        'img_url',
                        'game' => [
                            'id',
                            'title',
                            'currency_name'
                        ]
                        ],
                    'status'
                ]
            ])
            ->assertJson([
                [
                    'user_id' => $user->id
                ]
            ]);
    }

    public function test_can_update_order_status()
    {
        $admin = User::find(1);
        $user = User::factory()->create(['role' => 'user']);

        $product = Product::find(1);

        $this->actingAs($user)->get('api/checkout/' . $product->id);

        $orders = Order::all();
        $order = $orders[0];

        $response = $this->actingAs($admin)->putJson('api/orders/' . $order->id, [
            'status' => 'succeed'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'id' => $order->id,
                'user_id' => $user->id,
                'product_id' => $product->id,
                'status' => 'succeed'
            ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'user_id' => $user->id,
            'product_id' => $product->id,
            'status' => 'succeed'
        ]);
    }
}
