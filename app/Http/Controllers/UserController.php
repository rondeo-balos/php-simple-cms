<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;

class UserController extends Controller {
    
    public function index( Request $request ) {
        $per_page = $request->get( 'per_page', "10" );
        $s = $request->get( 's', '' );
        $data = User::whereAny( ['name', 'email'], 'like', '%'.$s.'%' )->latest()->paginate( $per_page );
        $data->getCollection()->transform( function($row) {
            $row->actions = [
                'edit' => route( 'user.edit', [$row->id] ),
                'delete' => route( 'user.delete', [$row->id] )
            ];
            return $row;
        });

        return Inertia::render( 'DataTable/Index', [
            'status' => session( 'status' ),
            'per_page' => $per_page,
            's' => $s,
            'title' => 'User',
            'add' => 'user.add',
            'columns' => [ 'id', 'name', 'email' ],
            'data' => $data
        ]);
    }

    public function add( Request $request ) {

        return Inertia::render( '', [
            'status' => session( 'status' )
        ]);
    }

    public function edit( Request $request, $id ) {

        return Inertia::render( '', [
            'status' => session( 'status' )
        ]);
    }

    public function delete( Request $request, $id ) {
        User::find( $id )->delete();

        return Redirect::back();
    }

}
