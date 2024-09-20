<?php

namespace App\Http\Controllers;

use App\Models\Collections;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;

class CollectionsController extends Controller {

    public function parent( Request $request ) {
        return Inertia::render( 'Collections/DataTable', [

        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index( Request $request, string $collection ) {
        $per_page = $request->get( 'per_page', '10' );
        $s = $request->get( 's', '' );

        $data = Collections::where( 'key', $collection )->whereLike( 'value', '%'.$s.'%' )->latest()->paginate( $per_page );
        $data->getCollection()->transform( function($row) use ($collection){
            $row->actions = [
                'edit' => route( 'collection.edit', [$collection, $row->id] ),
                'delete' => route( 'collection.delete', [$collection, $row->id] )
            ];
            return $row;
        });

        return Inertia::render( 'Collections/Formatter', [
            'status' => session( 'status' ),
            'per_page' => $per_page,
            's' => $s,
            'title' => $collection,
            'add' => route( 'collection.add', [$collection] ),
            'columns' => [ 'id', 'value' ],
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
        $data = Collections::find( $ID );

        return Inertia::render( 'Collections/Index', [
            'status' => session( 'status' ),
            'title' => 'Edit ' . $collection,
            'collection' => $collection,
            'id' => $ID,
            'data' => json_decode($data['value'])
        ]);
    }

    public function create( FormRequest $request, string $collection ) {
        $data = Collections::create([
            'key' => $collection,
            'value' => json_encode( $request->all() )
        ]);

        return Redirect::route( 'collection', [$collection] );
    }

    public function update( FormRequest $request, string $collection, string $ID ) {
        Collections::where( 'id', $ID )->update([
            'key' => $collection,
            'value' => json_encode( $request->all() )
        ]);

        return Redirect::route( 'collection.edit', [$collection, $ID] );
    }

    public function delete( string $collection, string $ID ) {
        Collections::where( 'id', $ID )->delete();

        return Redirect::back();
    }

    public function api( Request $request, string $collection ) {
        
        $per_page = $request->get( 'per_page', '10' );
        $s = $request->get( 's', '' );

        $data = Collections::where( 'key', $collection )->whereLike( 'value', '%'.$s.'%' )->latest()->paginate( $per_page );

        return response()->json( $data );
    }
}
