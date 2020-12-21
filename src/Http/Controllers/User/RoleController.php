<?php
namespace WFN\Admin\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends \WFN\Admin\Http\Controllers\Crud\Controller
{

    protected function _init(Request $request)
    {
        $this->gridBlock   = new \WFN\Admin\Block\User\Role\Grid($request);
        $this->formBlock   = new \WFN\Admin\Block\User\Role\Form();
        $this->entity      = new \WFN\Admin\Model\User\Role();
        $this->entityTitle = 'Admin User Roles';
        $this->adminRoute  = 'admin.user.role';
        return $this;
    }

    protected function _prepareData($data)
    {
        $data['resources'] = json_decode($data['resources'], true);
        return parent::_prepareData($data);
    }

    protected function validator(array $data)
    {
        $rules = [
            'title'     => 'required|string|max:255',
            'resources' => 'required',
        ];
        return Validator::make($data, $rules);
    }
}
