<?php

class Application_Form_FeeStructure extends Zend_Form
{
	public function init()
	{
// 	    $Academic_model = new Application_Model_Department();
	  
// 		$data = $Academic_model->getFeeDropDownList();
		
// 		//print_r($data); die;
// 		$academic_id = $this->createElement('select','department_id')
// 							->removeDecorator('label')
// 							->setAttrib('class',array('form-control','chosen-select'))
// 						   ->setAttrib('required','required')
// 							->removeDecorator("htmlTag")
// 							->addMultiOptions(array('' => 'Select'))
// 							->addMultiOptions($data);
//         $this->addElement($academic_id);	
        
   if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
          $token = $_SESSION['token'];
        $csrftoken = $this->createElement('hidden', 'csrftoken')
                ->removeDecorator('label')->setAttrib('class', array('form-control'))
                ->setAttrib('required', 'required')
                ->setRequired(true)
                ->setValue($token)
                ->removeDecorator("htmlTag");
        $this->addElement($csrftoken); 
        
        $Academic_model = new Application_Model_Academic();
        $data = $Academic_model->getFeeDropDownList();
        //print_r($data); die;
        $academic_id = $this->createElement('select', 'academic_id')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setAttrib('required', 'required')->setRequired(true)
                ->removeDecorator("htmlTag")
                ->addMultiOptions(array('' => 'Select'))
                ->addMultiOptions($data);

        $this->addElement($academic_id);
		
		
		//$Academic_model = new Application_Model_CastCategory();
        //$data = $Academic_model->getDropDownList();
        //print_r($data); die;
        //$cast = $this->createElement('select', 'cast_category')
        //        ->removeDecorator('label')
        //        ->setAttrib('class', array('form-control', 'chosen-select'))
         //       ->setAttrib('required', 'required')->setRequired(true)
         //       ->removeDecorator("htmlTag")
         //       ->addMultiOptions(array('' => 'Select'))
          //      ->addMultiOptions($data);

        //$this->addElement($cast);
	}
	
	
	
}