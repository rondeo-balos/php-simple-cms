<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMedia;
use App\Models\Media;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;

class MediaController extends Controller {

    public function index() {
        $media = Media::latest()->get();

        return Inertia::render( 'Media/Index', ['media' => $media] );
    }

    public function create( StoreMedia $request ) {
        $path = '';

        if( $request->hasFile( 'file' ) ) {
            $path = $request->file( 'file' )->store( 'media', 'public' );
        }

        $data = Media::create([
            'title' => $request->get( 'title' ),
            'alt' => $request->get( 'alt' ),
            'file' => $path
        ]);

        return Redirect::route( 'media' );
    }

    public function update( FormRequest $request, string $ID ) {

        Media::where( 'id', $ID )->update([
            'title' => $request->get( 'title' ),
            'alt' => $request->get( 'alt' )
        ]);

        return Redirect::route( 'media' );
    }

    public function delete( string $ID ) {
        Media::where( 'id', $ID )->delete();

        return Redirect::route( 'media' );
    }

    public function api( Request $request ): JsonResponse {
        $media = Media::latest()->get(['title', 'alt', 'file']);

        return response()->json($media);
    }
}
