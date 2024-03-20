<?php
namespace simpl;

use Illuminate\Database\Capsule\Manager as Manager;

class Db {
    
    public static function createInstance() : Manager {
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

        return $capsule;
    }

}