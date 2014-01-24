<?php
class Model_Db_Person extends Zend_Db_Table_Abstract
{
    protected $_name    = 'person';
    protected $_primary = 'id';
    
    public function __construct(){
        $db = Zend_Registry::get('donor_db');
        parent ::__construct($db);  
    }
}