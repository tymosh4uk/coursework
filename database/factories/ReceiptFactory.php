<?php

namespace Database\Factories;

use App\Models\Kitchen;
use App\Models\Receipt;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\File;


class ReceiptFactory extends Factory
{
    protected $model = Receipt::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $url = "https://thisartworkdoesnotexist.com";
//        $url = "https://thiscatdoesnotexist.com";
        $contents = file_get_contents($url);
        $name = $this->faker->unixTime.'_'.$this->faker->word.'.jpg';
        Storage::disk('public')->put('images/'.$name, $contents);

        return [
            'name' => $this->faker->word(),
            'cooking_hours' => $this->faker->time('H'),
            'cooking_minutes' => $this->faker->time('i'),
            'main_img' => $name,
//            'id_category' => factory(Category::class)->create()->id,
//            'id_kitchen' => factory(Kitchen::class)->create()->id,
//            'id_user' => factory(User::class)->create()->id,
            'id_category' => $this->faker->randomElement(Category::all())['id'],
            'id_kitchen' => $this->faker->randomElement(Kitchen::all())['id'],
            'id_user' => $this->faker->randomElement(User::all())['id'],
            'advice' => $this->faker->text(200),
            'created_at' => $this->faker->dateTimeBetween('-2 months', '-1 months'),
            'updated_at' => $this->faker->dateTimeBetween('-2 months', '-1 months'),
        ];
    }
}
