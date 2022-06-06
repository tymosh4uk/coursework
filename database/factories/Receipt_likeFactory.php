<?php

namespace Database\Factories;

use App\Models\Receipt_dislike;
use App\Models\Receipt_like;
use Illuminate\Database\Eloquent\Factories\Factory;

class Receipt_likeFactory extends Factory
{
    protected $model = Receipt_like::class;

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
     * @return Receipt_likeFactory
     */
    public function setReceiptId(?int $receipt_id): Receipt_likeFactory
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
     * @return Receipt_likeFactory
     */
    public function setUserId(?int $user_id): Receipt_likeFactory
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
        $user_id = $this->getUserId();
        $receipt_id = $this->getReceiptId();

        Receipt_dislike::where([['receipt_id', '=', $receipt_id], ['user_id', '=', $user_id]])->delete();
//        Receipt_dislike::where(['receipt_id', '=', $receipt_id ,'user_id', '=', $user_id])->delete();

        return [
            'user_id' => $this->getUserId(),
            'receipt_id' => $this->getReceiptId(),
            'created_at' => $this->faker->dateTimeBetween('-2 months', '-1 months'),
            'updated_at' => $this->faker->dateTimeBetween('-2 months', '-1 months'),
        ];
    }
}
