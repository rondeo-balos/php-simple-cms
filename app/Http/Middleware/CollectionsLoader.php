<?php

namespace App\Http\Middleware;

use Closure;
use File;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use View;
use Symfony\Component\Yaml\Yaml;

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
            $yaml_file_path = $path . '/' . $collection_name . '.yaml';

            if( File::exists($yaml_file_path) ) {
                $collection = Yaml::parseFile( $yaml_file_path );
                $collections[strtolower($collection_name)] = $collection;
            }
        }

        View::share( 'collections', $collections ); // Share collections

        return $next($request);
    }
}
