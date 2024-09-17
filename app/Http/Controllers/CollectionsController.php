<?php

namespace App\Http\Controllers;

use App\Models\Collections;
use App\Http\Requests\StoreCollectionsRequest;
use App\Http\Requests\UpdateCollectionsRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CollectionsController extends Controller {

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

        return Inertia::render( 'DataTable/Index', [
            'status' => session( 'status' ),
            'per_page' => $per_page,
            's' => $s,
            'title' => $collection,
            'add' => route( 'collection.add', [$collection] ),
            'columns' => [ 'id', 'value' ],
            'data' => $data
        ]);
    }

    public function add( Request $request, string $collection ) {

        return Inertia::render( 'Collections/Index', [
            'status' => session( 'status' ),
            'title' => 'Create ' . $collection,
            'collection' => $collection
        ]);
    }
}
