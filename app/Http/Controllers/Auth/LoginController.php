<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Storage;
use File;
use Artisan;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $res)
    {
        $input = $res->all();

        $this->validate($res,[
            // 'email' => 'required|email',
            'username' => 'required',
            'password' => 'required'
        ]);
        if (auth()->attempt(array('username'=>$input['username'],'password'=>$input['password']))) {
           if (auth()->user()->type == 'ADMIN') {
               return redirect()->route('main_admin');
            } elseif(auth()->user()->type == 'STAFF') {
                return redirect()->route('main_staff');
            } elseif(auth()->user()->type == 'MANAGE') {
                return redirect()->route('main_manage');     
            } elseif(auth()->user()->type == 'USER') {
                return redirect()->route('main_user');  
            // } elseif(auth()->user()->type == 'RPST') {
            //     return redirect()->route('rpst.home_rpst');         
           } else {
                return redirect()->route('home');
           }
        }else{
            return redirect()->route('login')->with('error','username and password Incorrect');
        }       
    }
    public function logout() {
        Auth::logout();
  
        return redirect('login');
      }
}
