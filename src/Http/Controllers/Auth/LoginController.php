<?php
namespace WFN\Admin\Http\Controllers\Auth;

use WFN\Admin\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    public function __construct()
    {
        $this->redirectTo = env('ADMIN_PATH', 'admin') . '/dashboard';
        $this->middleware('admin:guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin::auth/login');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        return redirect($this->redirectTo);
    }

    protected function authenticated(Request $request, $user)
    {
        return redirect($this->redirectTo);
    }

}
