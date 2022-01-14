<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Client;
use App\Models\ProblemType;
use App\Models\Product;
use App\Models\ProductStatus;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = ProductStatus::inRandomOrder()->first()->id;
        $user = null;
        $claimed = null;
        $finished = null;
        $audited = false;
        $date = Carbon::createFromTimestamp(rand(now()->subYear()->timestamp, now()->subMonth()->subMonth()->timestamp));
        if ($status != ProductStatus::FOR_REPAIR){
            $user = User::technicians()->active()->inRandomOrder()->first()->id;
            $claimed = $date;
        }
        if($status == ProductStatus::REPAIRED){
            $audited = true;
            $finished = $claimed->addMonth()->addDays(rand(1, 15))->format('Y-m-d H:i:s');
        }

        if ($claimed){
            $claimed = $claimed->format('Y-m-d H:i:s');
        }
        $client = Client::inRandomOrder()->first();

        return [
            'location' => $this->faker->state,
            'reported_by' => ($client->internal) ? $this->faker->name : null,
            'serial' => rand(1000000000, 9999999999),
            'description' => $this->faker->words(10, true),
            'parts' => $this->faker->words(5, true),
            'audited' => $audited,
            'client_id' => $client->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'product_status_id' => $status,
            'problem_type_id' => ProblemType::inRandomOrder()->first()->id,
            'user_id' => $user,
            'created_at' => $date->format('Y-m-d H:i:s'),
            'updated_at' => $date->format('Y-m-d H:i:s'),
            'claimed_at' => $claimed,
            'finished_at' => $finished,
            'reported_at' => $finished,
        ];
    }
}
