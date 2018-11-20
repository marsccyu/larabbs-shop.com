<?php

use Faker\Generator as Faker;

$factory->define(App\Models\UserAddress::class, function (Faker $faker) {
    $addresses = [
        ["台北市", "中正區", "中山路"],
        ["新北市", "蘆洲區", "民族路"],
        ["台中市", "中一區", "中港路"],
        ["高雄市", "南區", "成功北路"],
        ["台南市", "北區", "花田路"],
    ];
    $address   = $faker->randomElement($addresses);

    return [
        'province'      => $address[0],
        'city'          => $address[1],
        'district'      => $address[2],
        'address'       => sprintf('第%d街道第%d號', $faker->randomNumber(2), $faker->randomNumber(3)),
        'zip'           => rand(0, 999),
        'contact_name'  => $faker->name,
        'contact_phone' => $faker->phoneNumber,
    ];
});
