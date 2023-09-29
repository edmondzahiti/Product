<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('12345678')
        ]);

        Product::factory(5)
            ->for($user)
            ->create();

        User::factory()
            ->has(Product::factory()->count(3))
            ->create();
    }
}
