<?php

namespace Database\Factories;

use App\Models\Receipt_comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class Receipt_commentFactory extends Factory
{
    protected $model = Receipt_comment::class;

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
     * @return Receipt_commentFactory
     */
    public function setReceiptId(?int $receipt_id): Receipt_commentFactory
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
     * @return Receipt_commentFactory
     */
    public function setUserId(?int $user_id): Receipt_commentFactory
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
            'comment' => $this->faker->text(200),
            'created_at' => $this->faker->dateTimeBetween('-2 months', '-1 months'),
            'updated_at' => $this->faker->dateTimeBetween('-2 months', '-1 months'),
        ];
    }
}
