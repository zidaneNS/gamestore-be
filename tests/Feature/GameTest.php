<?php

namespace Tests\Feature;

use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GameTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_games(): void
    {
        $response = $this->get('api/games');

        $response
            ->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                    'description',
                    'category',
                    'img_url',
                    'currency_name',
                    'products' => [
                        '*' => [
                            'id',
                            'amount',
                            'price',
                            'original_price',
                            'game_id',
                            'img_url'
                        ]
                    ]
                ]
            ]);
    }

    public function test_can_get_game_details(): void
    {
        $game = Game::find(1);

        $response = $this->get('api/games/' . $game->id);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'title',
                'description',
                'category',
                'img_url',
                'currency_name',
                'products' => [
                    '*' => [
                        'id',
                        'amount',
                        'price',
                        'original_price',
                        'game_id',
                        'img_url'
                    ]
                ]
            ]);
    }
}
