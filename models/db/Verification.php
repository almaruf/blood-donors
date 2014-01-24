<?php
class Model_Db_Verification extends Zend_Db_Table_Abstract
{
    protected $_name    = 'verification';
    protected $_primary = 'id';
    
    public function __construct(){
        $db = Zend_Registry::get('donor_db');
        parent ::__construct($db);  
    }
}