<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\TypeRelease;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(100)->create();

        TypeRelease::factory(300)->create();

        User::factory()->create([
            'nome' => 'Rafael Fernandes',
            'email' => 'rafael.fernandes@example.com',
        ]);
    }
}
