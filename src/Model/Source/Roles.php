<?php
namespace WFN\Admin\Model\Source;

use WFN\Admin\Model\User\Role;

class Roles extends AbstractSource
{

    protected function _getOptions()
    {
        $options = [];
        foreach(Role::all() as $role) {
            $options[$role->id] = $role->title;
        }
        return $options;
    }

}
