<?php
require_once "vendor/autoload.php";
require_once "config.php";

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

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

Capsule::schema()->dropIfExists('users');
Capsule::schema()->create('users', function (Blueprint $table){
    $table->increments('id');
    $table->string('name')->nullable(false);
    $table->string('email')->unique();
    $table->string('password')->nullable(false);;
    $table->dateTime('date_registration')->nullable(false);
    $table->timestamps();
});

Capsule::schema()->dropIfExists('blog');
Capsule::schema()->create('blog', function (Blueprint $table){
    $table->increments('id');
    $table->string('message')->nullable(false);
    $table->dateTime('date')->nullable(false);
    $table->integer('user_id')->nullable(false)->unsigned();
    $table->string('img')->nullable(false)->default('');
    $table->timestamps();
});

print_r($capsule->getConnection()->getQueryLog());