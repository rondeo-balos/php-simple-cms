<?php

namespace App\Http\Middleware;

use Closure;
use File;
use Illuminate\Http\Request;
use Log;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;
use View;

class ComponentsLoader {

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        $path = app_path( 'ComponentDef' );
        $definitions = [];
        $files = File::files( $path );

        foreach( $files as $file ) {
            $component_name = pathinfo( $file->getFilename(), PATHINFO_FILENAME );
            $yaml_file_path = $path . '/' . $component_name . '.yaml';

            if( File::exists($yaml_file_path) ) {
                $definition = Yaml::parseFile( $yaml_file_path );
                $definitions[strtolower($component_name)] = $definition;
            }
        }

        Log::info( 'components loaded: ' . json_encode($definitions) );

        View::share( 'componentDefinitions', $definitions ); // Share components

        return $next($request);
    }
}
