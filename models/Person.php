<?php
class Model_Person extends Model_Abstract{

    public $id;
    public $name;        
    public $profile_image;    
    public $mobile_number;
    public $secondary_contact;    
    public $dob;
    public $weight;
    
    public $ward;
    public $union;
    public $thana;
    public $district;
    public $division;
    public $country;
    
    // donor specific info 
    public $blood_group;
    
    const PERSON_TYPE_DONOR = 'Donor';
    const PERSON_TYPE_SUBSCRIBER = 'Subscriber';    
 
    public function __construct($options = null){
        parent::__construct($options); 
    }
    
    public function getUserType(){
        if($this->getBloodGroup()){
            return self::PERSON_TYPE_DONOR;
        }      
        
        return self::PERSON_TYPE_SUBSCRIBER;
    }
    
    
    /*
    *
    *    SETTERS AND GETTERS 
    *
    */
        
    public function setId($value){
        $this->id = $value;
        return $this;
    }
    public function getId(){
        return $this->id; 
    }
        
    public function setName($value){
        $this->name = $value;
        return $this;
    }
    public function getName(){
        return $this->name; 
    }
        
    public function setProfileImage($value){
        $this->profile_image = $value;
        return $this;
    }
    public function getProfileImage(){
        return $this->profile_image; 
    }
        
    public function setMobileNumber($value){
        $this->mobile_number = $value;
        return $this;
    }
    public function getMobileNumber(){
        return $this->mobile_number; 
    }
        
    public function setSecondaryContact($value){
        $this->secondary_contact = $value;
        return $this;
    }
    public function getSecondaryContact(){
        return $this->secondary_contact; 
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
