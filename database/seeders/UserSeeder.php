<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = config("users", []);

        foreach ($users as $userData) {

            $userData['password'] = Hash::make(Arr::get($userData, 'password'));

            User::updateOrCreate(
                ['email' => Arr::get($userData, 'email')],
                $userData
            );
        }

        $this->command->info('Seeded users (email / password):');
        foreach ($users as $user) {
            $this->command->line(Arr::get($user, 'email') . ' / 12341234');
        }
    }
}
