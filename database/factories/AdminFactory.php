<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Admin;
use Faker\Generator as Faker;

$factory->define(Admin::class, function (Faker $faker) {
    return [
        'name' => 'admin',
        'email' => 'admin@admin.com',
        'is_manger' => 0,
        'email_verified_at' => now(),
        'password' => bcrypt('12345678'), 
        'remember_token' => Str::random(10),
    ];
});
