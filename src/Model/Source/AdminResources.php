<?php
namespace WFN\Admin\Model\Source;

class AdminResources extends AbstractSource
{

    protected $options = [];
    
    protected $ignoreRoutes = [
        'admin.login.post', 'admin.logout', 'admin.password.reset.post', 'admin.password.reset', 'admin.password.email'
    ];

    protected function _getOptions()
    {
        if(!$this->options) {
            $this->getOptionsTreeData([]);
        }
        return $this->options;
    }

    public function getOptionsTreeData($selected)
    {
        $this->selected = $selected ?: [];
        $rootNode = [
            'text'  => 'All',
            'id'    => 'admin',
            'nodes' => [],
        ];
        $this->options[$rootNode['id']] = $rootNode['text'];
        
        $routes = app('router')->getRoutes();
        $routesArray = array_merge($routes->get('GET'), $routes->get('POST'));
        $this->routeNames = [];

        foreach($routesArray as $route) {
            if(strpos($route->getName(), 'admin.') === 0 && !in_array($route->getName(), $this->ignoreRoutes)) {
                $this->routeNames[] = $route->getName();
            }
        }

        $rootNode = $this->_buildNodesTree($rootNode, $this->_getChildrens(2, $rootNode['id']));
        
        if(in_array($rootNode['id'], $this->selected)) {
            $rootNode['state'] = ['selected' => true];
        }
        return json_encode([$rootNode]);
    }

    protected function _buildNodesTree($node, $childrens, $level = 2)
    {
        $node['nodes'] = [];
        foreach($childrens as $name) {
            $_node = [
                'text' => ucfirst($name),
                'id'   => $node['id'] . '.' . $name,
            ];
            $_node = $this->_buildNodesTree($_node, $this->_getChildrens($level + 1, $_node['id']), $level + 1);

            if(in_array($_node['id'], $this->selected)) {
                $_node['state'] = ['selected' => true];
            }

            $node['nodes'][] = $_node;
            $this->options[$_node['id']] = $node['text'] . ' ' . $_node['text'];
        }

        if(count($node['nodes']) == 0) {
            unset($node['nodes']);
        }

        return $node;
    }

    protected function _getChildrens($level, $parent)
    {
        $childrens = [];
        foreach($this->routeNames as $name) {
            if(strpos($name, $parent) === false) {
                continue;
            }

            $name = explode('.', $name);
            if(isset($name[$level - 1])) {
                $childrens[] = $name[$level - 1];
            }
        }
        return array_unique($childrens);
    }

}
