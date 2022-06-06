<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Ingradient;
use App\Models\Kitchen;
use App\Models\Receipt;
use App\Models\Receipt_dislike;
use App\Models\Saved;
use App\Models\User;
use App\Models\Step;
use App\Models\Receipt_like;
use App\Models\Receipt_comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        $users = User::factory()->count(20)->create();
        $categories = Category::factory()->count(10)->create();
        $kitchens = Kitchen::factory()->count(10)->create();
        $receipts = Receipt::factory()->count(15)
            ->has(Ingradient::factory()->count(5), 'ingradient')
            ->create();

        foreach ($receipts as $receipt) {
            $step = Step::factory()
                ->count(5)
                ->setReceiptId($receipt->id)
                ->create();

        }

        foreach ($receipts as $receipt) {
            foreach ($users as $user) {
                $random_value = rand(0,11);
                if($random_value % 3 == 0) {
                    $like = Receipt_like::factory()
                        ->setReceiptId($receipt->id)
                        ->setUserId($user->id)
                        ->create();
                }
                $random_value = rand(0,11);
                if($random_value % 3 == 0) {
                    $dislike = Receipt_dislike::factory()
                        ->setReceiptId($receipt->id)
                        ->setUserId($user->id)
                        ->create();
                }
                $random_value = rand(0,11);
                if($random_value % 3 == 0) {
                    $comment = Receipt_comment::factory()
                        ->setReceiptId($receipt->id)
                        ->setUserId($user->id)
                        ->create();
                }
                $random_value = rand(0,11);
                if($random_value % 3 == 0) {
                    $saved = Saved::factory()
                        ->setReceiptId($receipt->id)
                        ->setUserId($user->id)
                        ->create();
                }
            }
        }


//        $user = factory(App\User::class)->create();
//        dd($user);
//
//        $user = User::factory()->create();
//        $category = Category::factory()->create();
//        $kitchen = Kitchen::factory()->create();
//        $receipt = Receipt::factory()
//            ->count(3)
//            ->for($user, $category, $kitchen)
//            ->create();
//        $user = $this->call(UsersTableSeeder::class);

//        factory(Category::class, 10)->create()->each(function ($user) {
//
//        });
//        $receipt = Receipt::factory()
//            ->count(3)
//            ->create(['id_user' => $user->id]);
//        dd($receipt);

        // \App\Models\User::factory(10)->create();
    }
}
