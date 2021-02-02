<?php

namespace Database\Factories\Finance;

use App\Models\Finance\Category;
use App\Models\Finance\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'             => $this->faker->name,
            'color'            => $this->faker->hexColor,
            'finance_group_id' => Group::factory(),
        ];
    }
}
