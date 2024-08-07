<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'testadmin@gmail.com',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Crear roles y permisos
        $role = Role::create(['name' => 'admin']);
        $permission = Permission::create(['name' => 'edit articles']);

        // Asignar rol y permiso a un usuario
        $user = User::find(1); // Obtén el usuario por ID
        $user->assignRole('admin');
        $user->givePermissionTo('edit articles');
    }
}
