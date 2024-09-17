<?php

namespace App\Http\Controllers;

use App\Http\Globals\AvailableComponents;
use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;

class PageController extends Controller {
    
    public function index( Request $request ) {
        $per_page = $request->get( 'per_page', "10" );
        $s = $request->get( 's', '' );
        $data = Page::whereAny( ['title', 'description'], 'like', '%'.$s.'%' )->latest()->paginate( $per_page );
        $data->getCollection()->transform( function($row) {
            $row->actions = [
                'edit' => route( 'page.edit', [$row->id] ),
                'delete' => route( 'page.delete', [$row->id] )
            ];
            return $row;
        });

        return Inertia::render( 'DataTable/Index', [
            'status' => session( 'status' ),
            'per_page' => $per_page,
            's' => $s,
            'title' => 'Page',
            'add' => route('page.add'),
            'columns' => [ 'id', 'title', 'description', 'visibility', 'path', 'status', 'author' ],
            'data' => $data
        ]);
    }

    public function add( Request $request ) {

        return Inertia::render( 'Page/Builder', [
            'status' => session( 'status' ),
            'components' => AvailableComponents::get()
        ]);
    }

    public function edit( Request $request, $id ) {

        return Inertia::render( 'Page/Builder', [
            'status' => session( 'status' )
        ]);
    }

    public function delete( Request $request, $id ) {
        Page::find( $id )->delete();

        return Redirect::back();
    }

}
