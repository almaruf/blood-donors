<?php
class Form_Abstract extends Zend_Form
{
    protected $_view = null;
    
    public function __construct($options = array()) {
        parent::__construct($options);
        $this->_view = Zend_Layout::getMvcInstance()->getView();
    }
    
    public function setAction($action) {
        $baseUrl = $this->getBaseUrl();
        return $this->setAttrib('action', (string) $baseUrl.$action);
    }
    
    public function setAutocompleteDateFields($fieldIds = array()){   
        $fieldIds = implode(', ',$fieldIds);
        $this->_view->inlineScript()
            ->appendScript(
                '$(function(){$("'. $fieldIds .'" ).datepicker({showAnim : "slide",dateFormat : "yy-m-d \'00:' 
                .  rand(0,10) . ':' .  rand(0,60) . '\'", minDate: 0 });});'
            );
    }
    
    private function getBaseUrl() {        
        return $this->_view->baseUrl();
    }   
    
}
