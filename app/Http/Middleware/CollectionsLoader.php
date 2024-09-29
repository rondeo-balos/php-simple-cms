<?php

namespace App\Http\Middleware;

use Closure;
use File;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use View;

class CollectionsLoader {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        $path = app_path( 'Collections' );
        $collections = [];
        $files = File::files( $path );

        foreach( $files as $file ) {
            $collection_name = pathinfo( $file->getFilename(), PATHINFO_FILENAME );
            $class_name = '\\App\\Collections\\' . $collection_name;

            if( class_exists( $class_name ) ) {
                $collection = call_user_func([$class_name, 'getCollection']);
                $collections[strtolower($collection_name)] = $collection;
            }
        }

        View::share( 'collections', $collections ); // Share collections

        return $next($request);
    }
}
