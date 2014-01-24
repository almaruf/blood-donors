<?php
class Model_Db_Sms extends Zend_Db_Table_Abstract
{
    protected $_name    = 'sms';
    protected $_primary = 'id';
    
    public function __construct(){
        $db = Zend_Registry::get('donor_db');
        parent ::__construct($db);  
    }
}