<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_products(): void
    {
        $response = $this->get('api/products');

        $response
            ->assertStatus(200)
            ->assertJsonCount(10)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'amount',
                    'price',
                    'original_price',
                    'game' => [
                        'id',
                        'title',
                        'description',
                        'category_id',
                        'img_url',
                        'currency_name',
                    ],
                    'img_url'
                ]
            ]);
    }
}
