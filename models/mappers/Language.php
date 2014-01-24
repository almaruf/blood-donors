<?
class Model_Mapper_Language extends Model_Mapper_Abstract
{
    public function getDictionary($lang){
        $select = $this->getLanguageTable()->getAdapter()->select();
        $select->from("language", array("en", $lang));
        return $this->getLanguageTable()->getAdapter()->fetchPairs($select);
    }
    
    public function updateField($id, $fieldName, $value){
        $data = array(
            $fieldName => $value
        );
        $where = $this->getLanguageTable()->getAdapter()->quoteInto('`id` = ?', $id);
        return $this->getLanguageTable()->update($data, $where);
	}
    
   // array('en'=>'test', 'bn'=>'');    
    public function save($data) {
        $where = $this->getLanguageTable()->getAdapter()->quoteInto("`en` = ?", $data['en']);
        $row = $this->getLanguageTable()->fetchRow($where);
        
        if(!$row){
            return $this->getLanguageTable()->insert($data);
        }else{
            $where = $this->getLanguageTable()->getAdapter()->quoteInto('`en` = ?', $data['en']);
            return $this->getLanguageTable()->update($data, $where);
        }        
	}

    public function find($id) {        
        $result = $this->getLanguageTable()->find($id);
        if(count($result)>0){
            return new Model_Language($result->current()->toArray());
        }
	}

    public function delete(Model_Language $obj){
        $where = $this->getLanguageTable()->getAdapter()->quoteInto('`id` = ?', $obj->getId());
        return $this->getLanguageTable()->delete($where);
    }
}
