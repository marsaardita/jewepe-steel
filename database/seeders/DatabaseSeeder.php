<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use LogicException;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (! $email && ! $password) {
            return;
        }

        if (! $email || ! $password) {
            throw new LogicException('Set both ADMIN_EMAIL and ADMIN_PASSWORD to seed an admin user.');
        }

        User::firstOrCreate(
            ['email' => $email],
            [
                'name' => env('ADMIN_NAME', 'Administrator'),
                'password' => $password,
            ]
        );
    }
}
