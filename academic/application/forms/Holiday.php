<?php

class Application_Form_Holiday extends Zend_Form
{
	public function init()
	{
            
            
           
        $Department_model = new Application_Model_DmiHoliday();
		$data = $Department_model->getDropDownList();
		//print_r($data); die;
		$holiday_id = $this->createElement('select','holiday')
				->removeDecorator('label')
				->setAttrib('class',array('form-control','chosen-select'))
                ->setRequired(true)
				->addMultiOptions(array('' => 'Select Year'))
				->addMultiOptions($data)
				->removeDecorator("htmlTag");
                $this->addElement($holiday_id);
		
		 
		
		
		
		
		
		
	
	}
	
}