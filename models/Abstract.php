<?php
abstract class Model_Abstract{
    
    private $_mapper_person;
    
    public function __construct(array $options = null){
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public function getFunctionNameFromFieldName($name){
        $parts = explode( '_' , $name );        
        @$newParts = array_map('ucfirst',$parts);        
        return implode($newParts);
    }
    
    public function __set($name, $value){
        $method = 'set' . $this->getFunctionNameFromFieldName($name);
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid note property');
        }
        $this->$method($value);
    }
 
    public function __get($name){
        $method = 'get' . $this->getFunctionNameFromFieldName($name);
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid note property');
        }
        return $this->$method();
    }
 
    public function setOptions(array $options){
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . $this->getFunctionNameFromFieldName($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
    
    
    public static function appendParamsIntoUrl($params = null, $url = null){
        if($url && strpos($url, "?") && $params) {
            $url .= "&" . http_build_query($params);
        } elseif($url && $params) {
            $url .= "?" . http_build_query($params);
        }elseif(!$url && $params){
            $url .= "?" . http_build_query($params);
        }

        return $url;
    }
    
    
    /*****************************
    *
    *   Mappers setter and getters 
    *
    ******************************/
    
    public function setPersonMapper($mapper) {
        $this->_mapper_person = $mapper;
        return $this;
    } 
    
    public function getPersonMapper() {
        if (null === $this->_mapper_person) {
                $this->setPersonMapper(new Model_Mapper_Person());
        }        
        return $this->_mapper_person;
    }
}
