<?php
namespace WFN\Admin\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use WFN\Admin\Model\User;

class UserController extends Crud\Controller
{

    protected function _init(Request $request)
    {
        $this->gridBlock   = new \WFN\Admin\Block\User\Grid($request);
        $this->formBlock   = new \WFN\Admin\Block\User\Form();
        $this->entity      = new \AdminUser();
        $this->entityTitle = 'Admin User';
        $this->adminRoute  = 'admin.user';
        return $this;
    }

    protected function _beforeDelete()
    {
        if(Auth::guard('admin')->user()->id == $this->entity->id) {
            throw new \Exception('Hey:) You can\'t delete yourself!');
        }

        if(\AdminUser::count() == 1) {
            throw new \Exception('Can\'t remove last administrator user');
        }
        
        return parent::_beforeDelete();
    }

    protected function _prepareData($data)
    {
        $existingUser = \AdminUser::where('email', $data['email'])->first();
        if($existingUser && !empty($data['id']) && $existingUser->id != $data['id']) {
            throw new \Exception('User with the same email already exists');
        }

        if(!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        return parent::_prepareData($data);
    }

    protected function validator(array $data)
    {
        $rules = [
            'name'    => 'required|string|max:255',
            'email'   => 'required|string|email|max:255' . (empty($data['id']) ? '|unique:admin_user' : ''),
            'role_id' => 'exists:admin_user_role,id',
        ];

        if(!empty($data['password'])) {
            $rules['password'] = 'string|min:8';
        }

        return Validator::make($data, $rules);
    }

}
