<?php

namespace App\Http\Controllers;

use Auth;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use PragmaRX\Google2FALaravel\Support\Authenticator;

class Verify2FAController extends Controller {
    
    public function index( Request $request ) {
        $authenticator = app(Authenticator::class)->boot($request);

        if( !Auth::user()->google2fa_secret || $authenticator->isAuthenticated() ) {
            return redirect()->intended( route('dashboard') );
        }
        return Inertia::render( 'Auth/2FA', [
            'status' => session( 'status' )
        ] );
    }

    public function verify( Request $request ) {
        $user = Auth::user();

        $request->validate([
            'one_time_password' => 'required|digits:6'
        ]);

        $google2fa = app( 'pragmarx.google2fa' );
        $valid = $google2fa->verifyKey( $user->google2fa_secret, $request->one_time_password );
        if( $valid ) {
            session()->forget( 'auth.2fa_pending' );

            $google2fa->login();

            return redirect()->intended( route('dashboard') );
        }

        return redirect()->back()->withErrors(['one_time_password' => 'Invalid authentication code.']);
    }

    public function qr( Request $request ) {
        $user = Auth::user();

        $google2fa = app('pragmarx.google2fa');
        $secret = $google2fa->generateSecretKey();
        session(['google2fa_secret' => $secret]);

        // Generate a QR code URL to show in the frontend
        $companyName = config( 'app.name' ); // Change to your app's name
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            $companyName,
            $user->email,
            $secret
        );

        return Inertia::render( 'Auth/2FAqr', [
            'status' => session( 'status' ),
            'qrCode' => $this->generateQr($qrCodeUrl),
            'secret' => $secret
        ] );
    }

    private function generateQr( $otpauth_url ) {
        // Create an instance of the QR code renderer
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new \BaconQrCode\Renderer\Image\SvgImageBackEnd()
        );

        // Generate a writer instance for generating the QR code
        $writer = new Writer($renderer);

        // Output the QR code as a Base64 encoded string (image)
        return $writer->writeString($otpauth_url);
    }

    public function enable( Request $request ) {
        $request->validate([
            'one_time_password' => 'required|digits:6',
        ]);

        $secret = session( 'google2fa_secret' );
        $google2fa = app( 'pragmarx.google2fa' );
        $valid = $google2fa->verifyKey($secret, $request->one_time_password);

        if ($valid) {
            // Save the secret in the database permanently
            Auth::user()->google2fa_secret = $secret;
            Auth::user()->save();

            session()->forget('google2fa_secret'); // Clear the session

            return redirect()->route('profile.edit')->with('status', '2FA is now enabled.');
        } else {
            return back()->withErrors(['one_time_password' => 'Invalid authentication code, please try again.']);
        }
    }

    public function disable( Request $request ) {
        $user = Auth::user();

        $user->google2fa_secret = null;
        $user->save();

        return redirect()->route( 'profile.edit' )->with( 'status', '2FA has been disabled!' );
    }

}