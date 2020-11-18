<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Topic::class, function (Faker $faker) {
    // 随机插入内容
    $sentence = $faker->sentence();

    //随机产生一个内的时间
    $updated_at = $faker->dateTimeThisMonth;


    //随机创建时间，为创建时间传传参，意为创建时间永远比修改时间早
    $created_at = $faker->dateTimeThisMonth($updated_at);

    return [
        'title' => $faker->name,
        'body' => $faker->text(),
        'excerpt' => $sentence,
        'user_id' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
        'category_id' => $faker->randomElement([1, 2, 3, 4]),
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
