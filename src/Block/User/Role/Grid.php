<?php
namespace WFN\Admin\Block\User\Role;

use WFN\Admin\Model\User\Role;

class Grid extends \WFN\Admin\Block\Widget\AbstractGrid
{

    protected $filterableFields = ['title'];

    protected $adminRoute = 'admin.user.role';

    public function getInstance()
    {
        return new Role();
    }

    protected function _beforeRender()
    {
        $this->addColumn('id', 'ID', 'text', true);
        $this->addColumn('title', 'Title');
        return parent::_beforeRender();
    }

    public function getTitle()
    {
        return 'Admin User Roles List';
    }

}