<?php

namespace App\Http\Controllers;

use App\Models\Collections;
use File;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Log;
use Redirect;
use Symfony\Component\Yaml\Yaml;
use Validator;

class CollectionsController extends Controller {

    private function getCollectionDef( string $collection, &$fail_safe ) {
        $yaml_file_path = app_path( 'Collections' ) . '/' . ucfirst($collection) . '.yaml';
        if( !File::exists($yaml_file_path) ) {
            Log::error( 'Unable to locate collection: ' . $collection . ', ' . $yaml_file_path );
            $fail_safe = true;
        }

        return Yaml::parseFile( $yaml_file_path );
    }

    /**
     * Display a listing of the resource.
     */
    public function index( Request $request, string $collection ) {
        $per_page = $request->get( 'per_page', '10' );
        $s = $request->get( 's', '' );

        $yaml = $this->getCollectionDef( $collection, $fail_safe );

        if( $fail_safe ) return Redirect::route( 'dashboard' )->withInput( ['status' => 'Unable to locate collection: ' . $collection] );

        $columns = [
            'id',
            ...$yaml['columns']
        ];

        $data = Collections::where( 'key', $collection )->whereRelation( 'metaData', 'value', 'like', '%'.$s.'%' )->latest()->paginate( $per_page );
        $data->getCollection()->transform( function($row) use ($collection){
            $row->actions = [
                'edit' => route( 'collection.edit', [$collection, $row->id] ),
                'delete' => route( 'collection.delete', [$collection, $row->id] )
            ];
            // Merge the pivoted meta data into the main row attributes
            $row->setRawAttributes(array_merge($row->getAttributes(), $row->pivoted_meta));
            // Optionally remove the meta_data array if you don't want it in the output
            unset($row->meta_data);
            return $row;
        });
        
        return Inertia::render( 'DataTable/Index', [
            'status' => session( 'status' ),
            'per_page' => $per_page,
            's' => $s,
            'title' => $collection,
            'add' => route( 'collection.add', [$collection] ),
            'columns' => $columns,
            'data' => $data,
            'collection' => $collection
        ]);
    }

    public function add( Request $request, string $collection ) {

        return Inertia::render( 'Collections/Index', [
            'status' => session( 'status' ),
            'title' => 'Create ' . $collection,
            'collection' => $collection
        ]);
    }

    public function edit( Request $request, string $collection, string $ID ) {
        $data = Collections::with( 'metaData' )->where( 'id', $ID )->first();
        $data->setRawAttributes(array_merge($data->getAttributes(), $data->pivoted_meta));
        unset($data->meta_data);

        return Inertia::render( 'Collections/Index', [
            'status' => session( 'status' ),
            'title' => 'Edit ' . $collection,
            'collection' => $collection,
            'id' => $ID,
            'data' => $data
        ]);
    }

    public function create( FormRequest $request, string $collection ) {
        $validation_rules = [];
        $yaml = $this->getCollectionDef( $collection, $fail_safe );
        if( $fail_safe ) return Redirect::route( 'dashboard' )->withInput( ['status' => 'Unable to locate collection: ' . $collection] );
        if( isset($yaml['meta']) ) {
            $meta = $yaml['meta'];
            foreach( $meta as $key => $metaFields ) {
                if( isset($metaFields['fields']) ) {
                    foreach( $metaFields['fields'] as $key => $field ) {
                        $validation_rules[$key] = $field['validate'] ?? '';
                    }
                } else {
                    $validation_rules[$key] = $metaFields['validate'] ?? '';
                }
            }
        }

        Validator::make( $request->all(), $validation_rules )->validate();

        $data = Collections::create([
            'key' => $collection
        ]);
        foreach( $request->all() as $key => $value ) {
            $data->metaData()->create([
                'key' => $key,
                'value' => $value
            ]);
        }

        return Redirect::route( 'collection', [$collection] );
    }

    public function update( FormRequest $request, string $collection, string $ID ) {
        $data = Collections::find( $ID );
        foreach( $request->all() as $key => $value ) {
            $data->metaData()->where( 'key', $key )->update([ 'value' => $value ]);
        }

        return Redirect::route( 'collection.edit', [$collection, $ID] );
    }

    public function delete( string $collection, string $ID ) {
        Collections::find( $ID )->delete();

        return Redirect::route( 'collection', [$collection] );
    }

    public function api( Request $request, string $collection ) {
        
        $per_page = $request->get( 'per_page', '10' );
        $s = $request->get( 's', '' );

        $data = Collections::where( 'key', $collection )->whereRelation( 'metaData', 'value', 'like', '%'.$s.'%' )->latest()->paginate( $per_page );
        $data->getCollection()->transform( function($row) {
            // Merge the pivoted meta data into the main row attributes
            $row->setRawAttributes(array_merge($row->getAttributes(), $row->pivoted_meta));
            // Optionally remove the meta_data array if you don't want it in the output
            unset($row->meta_data);
            return $row;
        });

        return response()->json( $data );
    }

    public function api_view( Request $request, string $collection, string $ID ) {
        $collection = Collections::where( 'key', $collection )->find( $ID );
        $data = $collection->setRawAttributes( array_merge($collection->getAttributes(), $collection->pivoted_meta) );

        return response()->json( $data );
    }
}