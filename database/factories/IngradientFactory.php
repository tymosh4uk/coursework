<?php

namespace Database\Factories;

use App\Models\Ingradient;
use Illuminate\Database\Eloquent\Factories\Factory;

class IngradientFactory extends Factory
{
    protected $model = Ingradient::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type_measuring = ['гр.', 'шт.', 'мл.', 'стак.', 'за смаком', 'чайних л.', 'столових л.'];
        $random_value = array_rand($type_measuring);

        return [
            'ingradient' => $this->faker->word(),
            'count_ingradient' => $this->faker->numberBetween(1, 1000),
            'type_measuring' => $type_measuring[$random_value],
            'created_at' => $this->faker->dateTimeBetween('-2 months', '-1 months'),
            'updated_at' => $this->faker->dateTimeBetween('-2 months', '-1 months'),
        ];
    }
}
