<?php

namespace seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Fazanis\LaravelBlockBots\Models\BotsBlockSettings;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        BotsBlockSettings::query()->create([
            'name'=>'Работа блокировщика',
            'value'=>true
        ]);
    }
}
