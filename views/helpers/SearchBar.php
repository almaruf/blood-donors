<?php
class Zend_View_Helper_SearchBar extends Zend_View_Helper_Abstract
{
    private $_html = null;    
    private $_params = array();
    private $_preDefinedSearchFields = array(
        'name' => array(             
            'type' => 'text', 
            'label' => 'Name',
            'values' => null, 
            'default' => null, 
            'date' => false
        ),
        'email' => array(         
            'type' => 'email', 
            'label' => 'Email',
            'values' => null, 
            'default' => null, 
            'date' => false
        ),
        'url' => array( 
            'type' => 'text', 
            'label' => 'Url',
            'values' => null, 
            'default' => null, 
            'date' => false
        ),
        'status' => array(
            'type' => 'select', 
            'label' => 'Status',
            'values' => array('active' => 'Active', 'inactive' => 'Inactive'), 
            'default' => null, 
            'date' => false
        ),
    );
    
    public function searchBar(array $searchFields, $action = null, $method = 'GET'){    
        if(is_array($searchFields)){
            foreach($searchFields as $fieldName){
                if(isset($this->_preDefinedSearchFields[ $fieldName ])){
                    $this->_params[ $fieldName ] = $this->_preDefinedSearchFields[ $fieldName ];
                }
            }
        }
        if(count($this->_params)<=0){
            return false; // terminte here because choose not to show any field
        }
                
        $this->_html .= "<form class='form-inline' role='form' action='$action' method='$method'>";

        foreach($this->_params as $paramName => $param){                
            if(isset($param['type']) && null !== $param['type']){
                $this->_html .= "<div class='form-group'>";            
                if(!isset($param['type']) || $param['type']=='text' || $param['type']=='email'){
                    $strings = $this->_renderTextField($param, $paramName);
                    $this->_html .= $strings['item'];
                }else if( $param['type']=='select' ){
                    if(is_array($param['values'])){
                        $strings = $this->_renderSelectField($param, $paramName);
                        $this->_html .= $strings['item'];
                    }
                }else {
                    throw new Exception( $param['type'] . " is not a valid field type in SearchBar view helper." );
                }            
                $this->_html .= "</div>";   
            }
        }
                
        $this->_html .= "<div class='form-group'>";
        $this->_html .= "<input type='submit' class='btn btn-primary btn-sm form-control' value='Go!'/>";        
        $this->_html .= "</div>";
        
        $this->_html .= "</form><hr>";
                
        return $this->_html;
    }
    
    
    private function _renderSelectField( $param, $paramName ){
        if(isset($param['label']) && null !== $param['label']){
            $label = $param['label'];
        }else{
            $label = ucfirst($paramName);
        }
        $selectedValue = null;
        if(isset($param['default']) && (null !== $param['default'])){
            $selectedValue = $param['default'];
        }
        if(isset($_REQUEST[ $paramName ])){
            $selectedValue = $_REQUEST[ $paramName ];
        }
        
        $string['label'] =  $label;
        $string['item'] =  "
        <select class='form-control' name='" . $paramName . "'>";
            foreach($param['values'] as $key=>$value){                
                $selected = '';
                if($selectedValue == $key){
                    $selected=' SELECTED';
                }
                $string['item'] .= "<option value='" . $key . "' $selected>" . ucfirst($value) . "</option>";
            }
        $string['item'] .= "</select>";
        return $string;
    }

    private function _renderTextField( $param, $paramName ){
        $dateClass = $defValue = '';           
        if(isset($param['date']) && $param['date'] == true ){
            $dateClass = 'datepicker';
        }
        $selectedValue = null;
        if(isset($param['default']) && null !== $param['default']){
            $selectedValue = $param['default'];
        }
        // after that check if the value has been changed by user
        if(isset($_REQUEST[ $paramName ])){
            $selectedValue = $_REQUEST[ $paramName ];
        }
        
        if(isset($param['label']) && null !== $param['label']){
            $label = $param['label'];
        }else{
            $label = ucfirst($paramName);
        }
        
        $type = $param['type'];
        $id = $paramName . rand(0, 99999999);
        $string['item'] = "<label class='sr-only' for='$id'>$label</label>";
        $string['item'] = "<input 
            class='$dateClass form-control' 
            type='$type' 
            id='$id' 
            placeholder='$label' 
            name='$paramName' value='$selectedValue'/>";
        
        return $string;
    }

    private function _getUrlDetails()
    {
        $front = Zend_Controller_Front::getInstance();
        $request = $front->getRequest();
        $this->_module = $request->getModuleName();
        $this->_controller = $request->getControllerName();
        $this->_action = $request->getActionName();
    }
}
        
