<?php

namespace Database\Seeders;

use App\Models\User;
use Bouncer;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(1)->create(
            [
                'first_name' => 'Sansa',
                'last_name' => 'Stark',
                'email' => 'sansa@stark.com',
                'email_verified_at' => null,
                'password' => bcrypt('pass12357'),
            ]
        );

        Bouncer::assign('admin')->to($users->first());

        $others = User::factory(2)->create();
        foreach ($others as $model) {
            Bouncer::assign('regular')->to($model);
        }
    }
}
