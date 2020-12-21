<?php
namespace WFN\Admin\Http\Controllers\Auth;

use WFN\Admin\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{

    use ResetsPasswords;

    public function __construct()
    {
        $this->redirectTo = env('ADMIN_PATH', 'admin') . '/dashboard';
        $this->middleware('admin:guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('admin::auth.passwords.reset')
            ->with(['token' => $token, 'email' => $request->email]
            );
    }
 
    protected function guard()
    {
        return Auth::guard('admin');
    }
 
    protected function broker()
    {
        return Password::broker('admins');
    }
}
