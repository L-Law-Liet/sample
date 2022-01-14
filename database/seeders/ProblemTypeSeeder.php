<?php

namespace Database\Seeders;

use App\Models\ProblemType;
use Illuminate\Database\Seeder;

class ProblemTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProblemType::factory(25)->create();
    }
}
