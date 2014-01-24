<?php
class Model_Db_Trail extends Zend_Db_Table_Abstract
{
    protected $_name    = 'trail';
    protected $_primary = 'id';
    
    public function __construct(){
        $db = Zend_Registry::get('donor_db');
        parent ::__construct($db);  
    }
}