<?php
namespace simpl\includes;

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

    public static function formatter( array | string $str, array | string $column, $before = '', $after = '' ): String {
        $formatted = [];
        if( is_string( $str ) ) {
            $formatted = explode( '|', $str );
        }

        if( count( $formatted ) <= 1 || strlen( $formatted[1] ) <= 0 )
            return $str;

        $formatted[1] = (int)$formatted[1] ?? $formatted[1];
        if( !is_int($formatted[1]) )
            return $str;

        $manager = self::createInstance()->getDatabaseManager();
        $data = $manager->table( $formatted[0] )->where( 'ID', $formatted[1] )->first( $column );
        if( $data )
            return $before . $data->$column . $after;

        return $str;
    }

}