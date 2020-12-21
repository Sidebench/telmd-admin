<?php
namespace WFN\Admin\Block\Widget;

use \Illuminate\Http\Request;

abstract class AbstractGrid
{

    const DEFAULT_PAGE_SIZE = 20;

    const DEFAUTL_ORDER_BY        = 'id';
    const DEFAUTL_ORDER_DIRECTION = 'desc';

    protected $request;

    protected $adminRoute;

    protected $collection = [];

    protected $columns = [];

    protected $buttons = [];

    protected $actions = [];

    protected $filterableFields = [];

    protected $instance;

    protected $_sources = [];

    public function __construct(\Illuminate\Http\Request $request)
    {
        parse_str(base64_decode($request->input('data')), $this->request);
    }

    abstract public function getInstance();

    public function render()
    {
        $this->_beforeRender();
        return view('admin::widget.grid', [
            'grid' => $this
        ]);
    }

    public function pagination()
    {
        $paginator = $this->getCollection();
        if($this->request) {
            $paginator->appends('data', base64_encode(http_build_query($this->request)));
        }
        return $paginator->links('admin::widget.pagination');
    }

    public function getRequest($index = false)
    {
        return $index ? ((isset($this->request[$index]) && $this->request[$index] !== '') ? $this->request[$index] : '') : $this->request;
    }

    public function getCollection()
    {
        return $this->_getCollection()->paginate(self::DEFAULT_PAGE_SIZE);
    }

    protected function _getCollection()
    {
        $query = $this->getInstance()
            ->newQuery();

        foreach($this->filterableFields as $field) {
            if(isset($this->request[$field]) && $this->request[$field] !== '') {
                if($this->columns[$field]['type'] == 'select') {
                    $query->where($field, $this->request[$field]);
                } else {
                    $query->where($field, 'like', '%' . $this->request[$field] . '%');
                }
            }
        }

        $query->orderBy($this->getOrderBy(), $this->getDirection());

        return $query;
    }

    public function getOrderBy()
    {
        return !empty($this->request['order_by']) ? $this->request['order_by'] : self::DEFAUTL_ORDER_BY;
    }

    public function getDirection()
    {
        return !empty($this->request['direction']) ? $this->request['direction'] : self::DEFAUTL_ORDER_DIRECTION;
    }

    public function getGridUrl()
    {
        return route($this->adminRoute);
    }

    public function getTitle()
    {
        return 'List Items';
    }

    public function addButton($label, $action, $route, $type = '', $class = '')
    {
        $this->buttons[] = [
            'label'  => $label,
            'action' => $action,
            'type'   => $type,
            'class'  => $class,
            'route'  => $route,
        ];
        return $this;
    }

    public function getButtons()
    {
        return $this->buttons;
    }

    public function addColumn($index, $label, $type = 'text', $sortable = true, $source = false, $options = [])
    {
        $this->columns[$index] = [
            'label'    => $label,
            'type'     => $type,
            'sortable' => $sortable,
            'source'   => $source,
            'options'  => $options,
        ];
        return $this;
    }

    public function isColumnFilterable($index)
    {
        return array_search($index, $this->filterableFields) !== false;
    }

    public function getColumns()
    {
        return $this->columns;
    }
    
    public function getColumnSourceModel($data)
    {
        $sourceClass = is_object($data['source']) ? get_class($data['source']) : $data['source'];
        if(empty($this->_sources[$sourceClass])) {
            if(!empty($sourceClass)) {
                $this->_sources[$sourceClass] = new $sourceClass();
                if(!$this->_sources[$sourceClass] instanceof \WFN\Admin\Model\Source\AbstractSource) {
                    throw new \Exception('Source class "' . $sourceClass . '" should be instance of \WFN\Admin\Model\Source\AbstractSource');
                }
            } else {
                throw new \Exception('Source class required for "select" field');
            }
        }
        return $this->_sources[$sourceClass];
    }

    public function addAction($title, $route, $type = '', $confirmation = false, $class = '')
    {
        $this->actions[$type] = [
            'label'        => $title,
            'route'        => $route,
            'type'         => $type,
            'confirmation' => $confirmation,
            'class'        => $class,
        ];
    }

    public function getActions()
    {
        return $this->actions;
    }

    protected function _beforeRender()
    {
        $this->addButton('Add New', route($this->adminRoute . '.new'), $this->adminRoute . '.new', 'add');

        $this->addAction('Edit', $this->adminRoute . '.edit', 'edit');
        $this->addAction('Delete', $this->adminRoute . '.delete', 'delete', true, 'danger');

        event(new \WFN\Admin\Events\GridRenderBefore($this));
        return $this;
    }

}