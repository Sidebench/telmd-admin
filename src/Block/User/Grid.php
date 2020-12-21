<?php
namespace WFN\Admin\Block\User;

use WFN\Admin\Model\Source\Roles;

class Grid extends \WFN\Admin\Block\Widget\AbstractGrid
{

    protected $filterableFields = [
        'name', 'email', 'role_id'
    ];

    protected $adminRoute = 'admin.user';

    public function getInstance()
    {
        return new \AdminUser();
    }

    protected function _beforeRender()
    {
        $this->addColumn('id', 'ID', 'text', true);
        $this->addColumn('name', 'Name');
        $this->addColumn('email', 'Email');
        $this->addColumn('role_id', 'Role', 'select', true, Roles::getInstance());
        return parent::_beforeRender();
    }

    public function getTitle()
    {
        return 'Admin Users List';
    }

}