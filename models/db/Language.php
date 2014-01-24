<?php
class Model_Db_Language extends Zend_Db_Table_Abstract
{
    protected $_name    = 'language';
    protected $_primary = 'id';
    
    public function __construct(){
        $db = Zend_Registry::get('donor_db');
        parent ::__construct($db);  
    }
}