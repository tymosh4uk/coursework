<?php

namespace Database\Factories;

use App\Models\Saved;
use Illuminate\Database\Eloquent\Factories\Factory;

class SavedFactory extends Factory
{
    protected $model = Saved::class;

    public ?int $receipt_id;
    public ?int $user_id;

    /**
     * @return int|null
     */
    public function getReceiptId(): ?int
    {
        return $this->receipt_id;
    }

    /**
     * @param int|null $receipt_id
     * @return SavedFactory
     */
    public function setReceiptId(?int $receipt_id): SavedFactory
    {
        $this->receipt_id = $receipt_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    /**
     * @param int|null $user_id
     * @return SavedFactory
     */
    public function setUserId(?int $user_id): SavedFactory
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_user' => $this->getUserId(),
            'id_receipt' => $this->getReceiptId(),
            'created_at' => $this->faker->dateTimeBetween('-2 months', '-1 months'),
            'updated_at' => $this->faker->dateTimeBetween('-2 months', '-1 months'),
        ];
    }
}
