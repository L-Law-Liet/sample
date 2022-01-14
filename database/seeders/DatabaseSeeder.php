<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            UserSeeder::class,
            ClientSeeder::class,
            CategorySeeder::class,
            ProductStatusSeeder::class,
            ProblemTypeSeeder::class,
            ProductSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
