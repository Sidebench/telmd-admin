<?php
namespace WFN\Admin\Block\Widget;

use File;

class AbstractForm
{
    protected $instance;

    protected $adminRoute;

    protected $buttons = [];
    
    protected $fields = [];

    protected $_standardFields = [];

    public function __construct()
    {
        $files = File::allFiles(config('admin_base_path') . '/views/widget/form/field');
        foreach ($files as $file)
        {
            $fieldname = $file->getRelativePathname();
            $fieldname = explode('.', $fieldname);
            $fieldname = array_shift($fieldname);
            $this->_standardFields[] = $fieldname;
        }
        return $this;
    }

    public function setInstance($instance)
    {
        $this->instance = $instance;
        return $this;
    }

    public function getInstance()
    {
        return $this->instance;
    }

    public function render()
    {
        $this->_beforeRender();
        return view('admin::widget.form', [
            'form' => $this
        ]);
    }

    public function getFormAction()
    {
        return route($this->adminRoute . '.save');
    }

    public function getTitle()
    {
        return ($this->getInstance()->id ? 'Edit Item' : 'New Item');
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
        array_unshift($this->buttons, [
            'label'    => 'Back',
            'action'   => route($this->adminRoute),
            'type'     => 'back',
            'route'    => $this->adminRoute,
        ]);

        if($this->getInstance()->id) {
            $this->buttons[] = [
                'label'        => 'Delete',
                'type'         => 'delete',
                'action'       => route($this->adminRoute . '.delete', ['id' => $this->getInstance()->id]),
                'class'        => 'danger',
                'confirmation' => true,
                'route'        => $this->adminRoute . '.delete',
            ];
        }

        $this->buttons[] = [
            'label'    => 'Save',
            'jsaction' => '$("#edit-form").submit()',
            'type'     => 'save',
            'class'    => 'success',
            'route'    => $this->adminRoute . '.save',
        ];
        return $this->buttons;
    }

    public function removeField($group, $index)
    {
        unset($this->fields[$group][$index]);
        if(empty($this->fields[$group])) {
            unset($this->fields[$group]);
        }
        return $this;
    }

    public function updateField($group, $index, $data)
    {
        if(empty($this->fields[$group][$index])) {
            return false;
        }
        $this->fields[$group][$index] = array_merge($this->fields[$group][$index], $data);
        return $this;
    }

    public function addField($group, $index, $label, $type = 'text', $options = [])
    {
        if(!empty($this->fields[$group][$index])) {
            return false;
        }
        
        $fieldData = [
            'name'     => $index,
            'label'    => $label,
            'type'     => $type,
            'value'    => $this->getInstance()->getAttribute($index)
        ];

        $fieldData = array_merge($fieldData, $options);

        if(!empty($fieldData['source'])) {
            $sourceClass = $fieldData['source'];
            $source = new $sourceClass();
            if(!$source instanceof \WFN\Admin\Model\Source\AbstractSource) {
                throw new \Exception('Source class "' . $sourceClass . '" should be instance of \WFN\Admin\Model\Source\AbstractSource');
            }
            $fieldData['source'] = $source;
        } elseif($type == 'select') {
            throw new \Exception('Source class required for "select" field');
        }
        
        if(!isset($this->fields[$group])) {
            $this->fields[$group] = [];
        }

        $this->fields[$group][$index] = $fieldData;
        return $this;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function getGroupLabel($group)
    {
        $label = str_replace('_', ' ', $group);
        return ucfirst($label);
    }

    protected function _beforeRender()
    {
        event(new \WFN\Admin\Events\FormRenderBefore($this));
        return $this;
    }

    public function getAfterFormHtml()
    {
        return '';
    }

}