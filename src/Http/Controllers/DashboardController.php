<?php
namespace WFN\Admin\Http\Controllers;

use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{

    public function index()
    {
        $viewPrefix = View::exists('admin.dashboard') ? 'admin.' : 'admin::';
        return view($viewPrefix . 'dashboard');
    }

}