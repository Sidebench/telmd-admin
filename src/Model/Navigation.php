<?php
namespace WFN\Admin\Model;

use Illuminate\Support\Facades\Auth;

class Navigation
{

    protected static $items = [];

    public static function getItems()
    {
        if(!static::$items) {
            static::_prepareItems();
        }
        return static::$items;
    }

    protected static function _prepareItems()
    {
        if(Auth::guard('admin')->user()->role->isAvailable('admin.dashboard')) {
            static::$items['dashboard'] = [
                'route' => 'admin.dashboard',
                'label' => 'Dashboard',
                'icon'  => 'icon-home',
            ];
        }

        foreach(config('adminNavigation', []) as $key => $data) {
            if($data = static::prepareItemData($data)) {
                static::$items[$key] = $data;
            }
        }

        if($items = static::_getSystemItems()) {
            static::$items['system'] = [
                'label' => 'System',
                'icon'  => 'icon-settings',
                'childrens' => $items,
            ];
        }
    }

    protected static function _getSystemItems()
    {
        $items = [];
        if(Auth::guard('admin')->user()->role->isAvailable('admin.user')) {
            $items['users'] = [
                'route' => 'admin.user',
                'label' => 'Manage Users',
            ];
        }
        if(Auth::guard('admin')->user()->role->isAvailable('admin.user.role')) {
            $items['user_roles'] = [
                'route' => 'admin.user.role',
                'label' => 'Manage Roles',
            ];
        }
        if(Auth::guard('admin')->user()->role->isAvailable('admin.settings')) {
            $items['settings'] = [
                'route' => 'admin.settings',
                'label' => 'Settings'
            ];
        }
        return $items;
    }

    protected static function prepareItemData($data)
    {
        if(!empty($data['route']) && !Auth::guard('admin')->user()->role->isAvailable($data['route'])) {
            return false;
        }

        if(!empty($data['childrens']) && is_array($data['childrens'])) {
            foreach($data['childrens'] as $index => $_data) {
                if(!empty($_data['route']) && !Auth::guard('admin')->user()->role->isAvailable($_data['route'])) {
                    unset($data['childrens'][$index]);
                }
            }
            if(count($data['childrens']) == 0) {
                return false;
            }
        }

        return $data;
    }

}