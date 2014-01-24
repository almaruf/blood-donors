<?php
/*
*   Model_Error
*   Model/Error.php
* 
*   @package    Model
*   @version    Error.php 1.0 
*/
class Model_Error extends Model_Abstract{

    public $id;
    public $code;
    public $desc;
    public $count;
    public $latest_ts;
         
    public function setId($value){
        $this->id = $value;
        return $this;
    }
    public function getId(){
        return $this->id; 
    }
    
    public function setCode($value){
        $this->code = $value;
        return $this;
    }
    public function getCode(){
        return $this->code; 
    }
    
    public function setCount($value){
        $this->count = $value;
        return $this;
    }
    public function getCount(){
        return $this->count; 
    }
    
    public function setDesc($value){
        $this->desc = $value;
        return $this;
    }
    public function getDesc(){
        return $this->desc; 
    }
    
    public function setLatestTs($value){
        $this->latest_ts = $value;
        return $this;
    }
    public function getLatestTs(){
        return $this->latest_ts; 
    }
}
