<?php
namespace simpl;

use Illuminate\Database\Capsule\Manager as Manager;

class DB {

    private static $capsule;

    public static function boot() {
        $settings = [
            'driver' => 'mysql',
            'host' => DB_HOST,
            'database' => DB_NAME,
            'username' => DB_USERNAME,
            'password' => DB_PASSWORD,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ];

        $capsule = new Manager;
        $capsule->addConnection($settings);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    public static function getCapsule() {
        return self::$capsule;
    }

}