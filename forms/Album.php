<?php
class Form_Donor extends Form_Abstract
{
	public function __construct($options = null)
	{
        parent::__construct($options);
        $this->setName('donor');
        $this->setMethod('post');        
        $this->setAttrib('role', 'form');

        $id = new Zend_Form_Element_Hidden('id');
        $name = new Zend_Form_Element_Hidden('name');
        $submit = new Zend_Form_Element_Submit('submit');
		        
		$name->setLabel('Your Name *')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->setAttrib('maxLength', 100)
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');
		
		$submit->setAttrib('class', 'btn btn-primary')
			->setLabel("Add new Album");
		
        $restaurant_id->setDecorators(array('ViewHelper'));           
        $id->setDecorators(array('ViewHelper'));		
		$this->addElements(array(
			$id,
            $name,
			$submit
		));
	}
}
