<?
class Model_Mapper_Person extends Model_Mapper_Abstract
{
    public function updateField($id, $fieldName, $value){
        $data = array(
            $fieldName => $value
        );
        $where = $this->getPersonTable()->getAdapter()->quoteInto('`id` = ?', $id);
        return $this->getPersonTable()->update($data, $where);
	}

    
    public function save(Model_Person $obj) {
		$data = array(
			'name' => $obj->getName(),
			'profile_image' => $obj->getProfileEmage(),			
			'mobile_number' => $obj->getMobileNumber(),
			'secondary_contact' => $obj->getSecondaryContact(),
			'dob' => $obj->getDob(),            
			'weight' => $obj->getWeight(),            
            'ward' => $obj->getWard(),
            'union' => $obj->getUnion(),
			'thana' => $obj->getThana(),			
			'district' => $obj->getDistrict(),
			'division' => $obj->getDivision(),
			'country' => $obj->getCountry(),            
			'blood_group' => $obj->getBloodGroup(),            
			'status' => $obj->getStatus(),            
		);

        if(!$obj->getId()){
            $id = $this->getPersonTable()->insert($data);
            $obj->setId($id);
            return $id;
        }else{        
            $where = $this->getPersonTable()->getAdapter()->quoteInto('`id` = ?', $obj->getId());
            return $this->getPersonTable()->update($data, $where);
        }        
	}

    public function find($id) {        
        $result = $this->getPersonTable()->find($id);
        if(count($result)>0){
            return new Model_Person($result->current()->toArray());
        }
	}

    public function delete(Model_Person $obj){
        $where = $this->getPersonTable()->getAdapter()->quoteInto('`id` = ?', $obj->getId());
        return $this->getPersonTable()->delete($where);
    }
}
