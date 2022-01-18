<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    private $data = [];

    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->data = [
                        'title'             => 'Verify Your Email Address',
                        'subtitle'          => '',
                        'menu'              => 'Verify Your Email Address',
                        'link_menu'         => '',
                        'icon_menu'         => 'icon-info22',
                        'submenu'           => '',
                        'link_submenu'      => '',
                        'icon_submenu'      => '',
                        'subsubmenu'        => '',
                        'icon_subsubmenu'   => '',
                        'route'             => 'verify',
                        'permission'        => 'verify',
                        'icon-primary'      => '',
                        'no'                => 1
                      ];
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');  
    }

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
                        ? redirect($this->redirectPath())
                        : view('auth.verify', $this->data);
    }
}
