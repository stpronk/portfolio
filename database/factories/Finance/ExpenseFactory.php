<?php

namespace Database\Factories\Finance;

use App\Models\Finance\Category;
use App\Models\Finance\Expense;
use App\Models\Finance\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Expense::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'                => $this->faker->title,
            'type'                => $this->faker->randomKey(Expense::$TYPES),
            'amount'              => $this->faker->randomNumber(5),
            'date'                => $this->faker->date(),
            'notes'               => $this->faker->sentence,
            'finance_group_id'    => Group::factory(),
            'finance_category_id' => Category::factory(),
        ];
    }
}
