<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller {
    
    public function index( Request $request ) {

        $data = User::latest()->paginate( 10 );

        return Inertia::render( 'DataTable/Index', [
            'status' => session( 'status' ),
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
