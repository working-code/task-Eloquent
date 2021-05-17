<?php
require_once "vendor/autoload.php";
require_once "config.php";

use Illuminate\Database\Capsule\Manager as Capsule;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Message;

$capsule = new Capsule();
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => DB_HOSTNAME,
    'database' => DB_DATABASE,
    'username' => DB_USERNAME,
    'password' => DB_PASSWORD,
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

//enable log
$capsule->getConnection()->enableQueryLog();

$faker = Faker::create('ru_RU');

for ($i = 0; $i < 30; $i++) {
    $user = new User();
    $user->name = $faker->name();
    $user->email = $faker->email();
    $user->password = $faker->password();
    $user->date_registration = $faker->dateTime();
    $user->save();
}

for ($i = 0; $i < 30; $i++) {
    $message = new Message();
    $message->message = $faker->realText();
    $message->user_id = mt_rand(1, 30);
    $message->date = $faker->dateTime();
    $message->save();
}

print_r($capsule->getConnection()->getQueryLog());