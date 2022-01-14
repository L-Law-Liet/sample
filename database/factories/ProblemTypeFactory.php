<?php

namespace Database\Factories;

use App\Models\ProblemType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProblemTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProblemType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->words(10, true),
            'payout' => rand(1000, 10000),
        ];
    }
}
