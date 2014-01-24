<?php
class Model_Mapper_Trail extends Model_Mapper_Abstract
{
    public function save(Model_Trail $obj){
        $data = array(
            'person_id' => $obj->getPersonId(),
            'admin_id' => $obj->getAdminId(),
            'story' => $obj->getStory(),
        );
        
        if(!$obj->getId()){
            $id = $this->getTrailTable()->insert($data);
            $obj->setId($id);
            return $id;
        }else{        
            $where = $this->getTrailTable()->getAdapter()->quoteInto('`id` = ?', $obj->getId());
            return $this->getTrailTable()->update($data, $where);
        }
	}
}
