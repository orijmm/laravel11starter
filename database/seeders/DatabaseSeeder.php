<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        try {
            $this->command->info('Seeders ejecutandose.');

            // Llama a otros seeders aquí
            $this->call([
                UserSeeder::class,
                SettingSeeder::class,
                WorldSeeder::class
            ]);

            // Mensaje si todo salió bien
            $this->command->info('Seeders ejecutados correctamente.');
        } catch (\Exception $e) {
            // Loguea el error
            Log::error($e->getMessage());

            // Muestra un mensaje en la consola
            $this->command->error('Ocurrió un error al ejecutar los seeders: ' . $e->getMessage());
        }
    }
}
