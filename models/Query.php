<?php
/*
*   Model_Query
*   Model/Query.php
* 
*   @package    Model
*   @version    Query.php 1.0 
*/
class Model_Query extends Model_Abstract{

    public $or_where;
    public $where;
    public $order;
    public $total;
    public $start = 0;
    public $rows = 20;
    
    public $person_id;
    public $type;    
    public $name;
    public $status;
    
    public $ward;
    public $union;
    public $thana;
    public $district;
    public $division;
    public $country;
    
    const ORDER_ID = 'id ASC';
    const ORDER_ID_DESC = 'id DESC';
    const ORDER_TS = 'ts ASC';
    const ORDER_TS_DESC = 'ts DESC';
    const ORDER_NAME = 'name ASC';
    const ORDER_NAME_DESC = 'name DESC';
    const ORDER_STATUS_TS = 'status_ts ASC';
    const ORDER_STATUS_TS_DESC = 'status_ts DESC';
            
    public function __construct($options = null){
        parent::__construct($options);
    }
    
    public function setWhere($values){
        if(is_array($values) && count($values)>0){
            foreach($values as $value){
                if(!is_string($value)){
                    throw new Exception(" Array of strings should be set for WHERE caluse. ie, array( ' name = name1' )  ");
                }
                $this->where[] = $value;
            }
            return $this;
        }        
        throw new Exception("Array expected.");
    }    
    public function getWhere(){
        return $this->where;
    }
        
    public function setOrWhere($values){
        if(is_array($values) && count($values)>0){
            foreach($values as $value){
                if(!is_string($value)){
                    throw new Exception(" Array of strings should be set for OR WHERE caluse. ie, array( ' name = name1' )  ");
                }
                $this->or_where[] = $value;
            }
            return $this;
        }        
        throw new Exception("Array expected.");
    }    
    public function getOrWhere(){
        return $this->or_where;
    }
        
    
    public function setOrder($value = null){
        $this->order = $value;         
        return $this;
    }    
    public function getOrder(){
        return $this->order;
    }
    
    
    public function setStart($value = null){        
        $this->start = $value;         
        return $this;
    }
    public function getStart(){
        return $this->start;
    }
        
    public function setRows($value = null){        
        $this->rows = $value;         
        return $this;
    }    
    public function getRows(){
        return $this->rows;
    }    
    
    public function setTotal($value = null){
        $this->total = $value;         
        return $this;
    }    
    public function getTotal(){
        return $this->total;
    }
    
    public function setPersonId($value = null){
        $this->person_id = $value;         
        return $this;
    }    
    public function getPersonId(){
        return $this->person_id;
    }
    
    public function setType($value = null){
        $this->type = $value;         
        return $this;
    }    
    public function getType(){
        return $this->type;
    }
    
    public function setStatus($value = null){
        $this->status = $value;         
        return $this;
    }    
    public function getStatus(){
        return $this->status;
    }
        
    public function setBloodGroup($value){
        $this->blood_group = $value;
        return $this;
    }
    public function getBloodGroup(){
        return $this->blood_group; 
    }
        
    public function setWard($value){
        $this->ward = $value;
        return $this;
    }
    public function getWard(){
        return $this->ward; 
    }
        
    public function setUnion($value){
        $this->union = $value;
        return $this;
    }
    public function getUnion(){
        return $this->union; 
    }
        
    public function setThana($value){
        $this->thana = $value;
        return $this;
    }
    public function getThana(){
        return $this->thana; 
    }
        
    public function setDistrict($value){
        $this->district = $value;
        return $this;
    }
    public function getDistrict(){
        return $this->district; 
    }
        
    public function setDivision($value){
        $this->division = $value;
        return $this;
    }
    public function getDivision(){
        return $this->division; 
    }
        
    public function setCountry($value){
        $this->country = $value;
        return $this;
    }
    public function getCountry(){
        return $this->country; 
    }
}
