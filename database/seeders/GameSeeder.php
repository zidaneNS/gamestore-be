<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = [
            [
                'title' => 'Mobile Legends',
                'id' => 1,
                'currency_name' => 'Diamonds'
            ],
            [
                'title' => 'Call Of Duty',
                'id' => 2,
                'currency_name' => 'Coins'
            ],
            [
                'title' => 'PUBG',
                'id' => 3,
                'currency_name' => 'UC'
            ]
        ];

        foreach ($games as $game) {
            Game::factory()->create([
                'title' => $game['title'],
                'category_id' => $game['id'],
                'currency_name' => $game['currency_name']
            ]);
        }
    }
}
