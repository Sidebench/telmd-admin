<?php
namespace WFN\Admin\Block\User\Role;

use WFN\Admin\Model\Source\AdminResources;

class Form extends \WFN\Admin\Block\Widget\AbstractForm
{

    protected $adminRoute = 'admin.user.role';

    protected function _beforeRender()
    {
        $this->addField('general', 'id', 'ID', 'hidden', ['required' => false]);
        $this->addField('general', 'title', 'Title', 'text', ['required' => true]);
        $this->addField('general', 'resources', 'Resources', 'acl', [
            'required' => true,
            'source'   => AdminResources::class
        ]);
        return parent::_beforeRender();
    }

}