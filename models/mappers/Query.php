<?php
class Model_Mapper_Query extends Model_Mapper_Abstract
{
    public function save(Model_Query $obj){
        $data = array(
            'id' => $obj->getId(),
            'result' => $obj->getTotal(),
            'ward' => $obj->getWard(),
            'union' => $obj->getUnion(),
			'thana' => $obj->getThana(),			
			'district' => $obj->getDistrict(),
			'division' => $obj->getDivision(),
			'country' => $obj->getCountry(),            
			'blood_group' => $obj->getBloodGroup(), 
        );
        
        if(!$obj->getId()){
            $id = $this->getQueryTable()->insert($data);
            $obj->setId($id);
            return $id;
        }else{        
            $where = $this->getQueryTable()->getAdapter()->quoteInto('`id` = ?', $obj->getId());
            return $this->getQueryTable()->update($data, $where);
        }
	}
}
