<?php
use Illuminate\Notifications\DatabaseNotification;

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Thread::class, function ($faker) {
    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'channel_id' => function () {
            return factory('App\Channel')->create()->id;
        },
        'title' => $faker->sentence,
        'body'  => $faker->paragraph
    ];
});

$factory->define(App\Channel::class, function ($faker) {
    $name = $faker->word;

    return [
        'name' => $name,
        'slug' => $name
    ];
});


$factory->define(App\Reply::class, function ($faker) {
    return [
        'thread_id' => function () {
            return factory('App\Thread')->create()->id;
        },
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'body'  => $faker->paragraph
    ];
});

$factory->define(DatabaseNotification::class, function ($faker) {
    return [
        'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),

        'type' => 'App\Notifications\ThreadWasUpdated',

        'notifiable_id' => function () {
            return auth()->id() ?: factory('App\User')->create()->id;
        },

        'notifiable_type' => 'App\User',

        'data' => ['foo' => 'bar']
    ];
});
