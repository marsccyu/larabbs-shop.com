<?php

use Illuminate\Database\Seeder;
use App\Models\UserAddress;
use App\Models\User;

class UserAddressSeeder extends Seeder
{
    public function run()
    {
        // 獲得 Faker 實例
        $faker = app(Faker\Generator::class);

        $user_ids = User::all()->pluck('id')->toArray();

        $userAddress = factory(UserAddress::class)
            ->times(10)
            ->make()
            ->each(function ($userAddres, $index)
            use ($faker, $user_ids)
            {
                // 從user_id陣列中隨機取出一個賦值
                $userAddres->user_id = $faker->randomElement($user_ids);
            });

        UserAddress::insert($userAddress->toArray());
    }
}
