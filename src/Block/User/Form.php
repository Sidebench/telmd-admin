<?php
namespace WFN\Admin\Block\User;

use WFN\Admin\Model\Source\Roles;

class Form extends \WFN\Admin\Block\Widget\AbstractForm
{

    protected $adminRoute = 'admin.user';

    protected function _beforeRender()
    {
        $this->addField('general', 'id', 'ID', 'hidden', ['required' => false]);
        $this->addField('general', 'name', 'First Name', 'text', ['required' => true]);
        $this->addField('general', 'email', 'Email', 'email', ['required' => true]);
        $this->addField('general', 'password', 'Password', 'password', ['required' => false]);
        $this->addField('general', 'role_id', 'Role', 'select', [
            'required' => true,
            'source'   => Roles::class
        ]);
        return parent::_beforeRender();
    }

}