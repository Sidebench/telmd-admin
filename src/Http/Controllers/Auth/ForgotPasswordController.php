<?php
namespace WFN\Admin\Http\Controllers\Auth;

use WFN\Admin\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Password;

class ForgotPasswordController extends Controller
{

    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('admin:guest');
    }

    public function showLinkRequestForm()
    {
        return view('admin::auth.passwords.email');
    }
 
    protected function broker()
    {
        return Password::broker('admins');
    }
}
