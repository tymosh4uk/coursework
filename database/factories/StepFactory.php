<?php

namespace Database\Factories;

use App\Models\Receipt;
use App\Models\Step;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class StepFactory extends Factory
{
    protected $model = Step::class;
    private static $counters = [];

    public ?int $receipt_id;

    /**
     * @return int|null
     */
    public function getReceiptId(): ?int
    {
        return $this->receipt_id;
    }

    /**
     * @param int|null $receipt_id
     * @return StepFactory
     */
    public function setReceiptId(?int $receipt_id): StepFactory
    {
        $this->receipt_id = $receipt_id;
        return $this;
    }


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
        Storage::disk('public')->put('step_images/'.$name, $contents);

        $receipt_id = $this->getReceiptId();

        $position = $this->nextCounterFor($receipt_id, static function() use ($receipt_id) {
            $lastPosition = Step::where('id_receipt', $receipt_id)->orderBy('step', 'DESC')->first();
            return $lastPosition !== null ? $lastPosition->step : 0;
        });


//        $previousReceiptId = Step::where(['id_receipt' => $this->getReceiptId()])->orderBy('id', 'DESC')->first();
//        dd($previousReceiptId);
        return [
            'id_receipt' => $this->getReceiptId(),
            'step' => $position,
            'step_image' => $name,
            'step_description' => $this->faker->text(200),
            'created_at' => $this->faker->dateTimeBetween('-2 months', '-1 months'),
            'updated_at' => $this->faker->dateTimeBetween('-2 months', '-1 months'),
        ];
    }

    private static function nextCounterFor($key, $default = 0)
    {
        if (!isset(self::$counters[$key])) {
            if (is_callable($default)) {
                $default = $default();
            }
            if (!is_int($default)) {
                throw new \RuntimeException('The default value must be an integer');
            }
            self::$counters[$key] = $default;
        }

        return ++self::$counters[$key];
    }
}
