<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller {
    
    public function index( Request $request ) {
        $per_page = $request->get( 'per_page', "10" );
        $s = $request->get( 's', '' );
        $data = User::whereAny( ['name', 'email'], 'like', '%'.$s.'%' )->latest()->paginate( $per_page );

        return Inertia::render( 'DataTable/Index', [
            'status' => session( 'status' ),
            'per_page' => $per_page,
            's' => $s,
            'title' => 'User',
            'add' => 'user.add',
            'columns' => [ 'id', 'name', 'email', 'action' ],
            'data' => $data
        ]);
    }

    public function add( Request $request ) {

        return Inertia::render( '', [
            'status' => session( 'status' )
        ]);
    }

}
