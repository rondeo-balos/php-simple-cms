<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Password;
use Redirect;
use Illuminate\Validation\Rules;

class UserController extends Controller {
    
    public function index( Request $request ) {
        $per_page = $request->get( 'per_page', '10' );
        $s = $request->get( 's', '' );
        $data = User::whereAny( ['name', 'email'], 'like', '%'.$s.'%' )->latest()->paginate( $per_page );
        $data->getCollection()->transform( function($row) {
            if( Auth::id() == $row->id ) {
                $row->actions =[
                    'profile' => route( 'profile.edit' )
                ];
                return $row;
            }
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
            'add' => route('user.add'),
            'columns' => [ 'id', 'name', 'email' ],
            'data' => $data
        ]);
    }

    public function add( Request $request ) {

        return Inertia::render( 'User/Index', [
            'status' => session( 'status' ),
            'title' => 'Add User'
        ]);
    }

    public function edit( Request $request, $id ) {
        $data = User::find( $id );

        return Inertia::render( 'User/Index', [
            'status' => session( 'status' ),
            'title' => 'Edit User',
            'id' => $id,
            'data' => $data
        ]);
    }

    public function create( Request $request ) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return Redirect::route( 'user' );
    }

    public function update( Request $request, $id ) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($id)],
        ]);
        User::find( $id )->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return Redirect::route( 'user' );
    }

    public function updatePassword( Request $request, $id ) {
        $validated = $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::find( $id )->update([
            'password' => Hash::make($validated['password']),
        ]);

        return Redirect::route( 'user' );
    }

    public function delete( Request $request, $id ) {
        User::find( $id )->delete();

        return Redirect::back();
    }

}
