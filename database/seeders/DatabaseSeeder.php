<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'althof@flipplay.test'],
            [
                'name' => 'Althof',
                'password' => Hash::make('password123'),
            ]
        );

        $mediaList = [
            [
                'title' => 'Inception',
                'type' => 'movie',
                'genre' => 'Sci-Fi',
                'duration_minutes' => 148,
            ],
            [
                'title' => 'The Batman',
                'type' => 'movie',
                'genre' => 'Action',
                'duration_minutes' => 176,
            ],
            [
                'title' => 'Interstellar',
                'type' => 'movie',
                'genre' => 'Sci-Fi',
                'duration_minutes' => 169,
            ],
        ];

        foreach ($mediaList as $item) {
            Media::firstOrCreate(
                ['title' => $item['title']],
                $item
            );
        }
    }
}
