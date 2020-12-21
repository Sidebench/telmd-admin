<?php
namespace WFN\Admin\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['admin:auth', \WFN\Admin\Http\Middleware\AllowedResource::class]);
    }

}