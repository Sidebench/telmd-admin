<?php

namespace WFN\Admin\Model\Source;

abstract class AbstractSource
{

    protected $options = [];

    public function getOptions()
    {
        if(empty($this->options)) {
            $this->options = $this->_getOptions();
        }
        return $this->options;
    }
    
    public function getOptionLabel($value)
    {
        $this->getOptions();
        return !empty($this->options[$value]) ? $this->options[$value] : '';
    }

    abstract protected function _getOptions();

    public static function getInstance()
    {
        return new static();
    }

}