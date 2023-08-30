<?php

class Application_Form_DirectFinalGrade extends Zend_Form
{
	public function init()
	{
			

	$Academic_model = new Application_Model_Academic();
		$data = $Academic_model->getDropDownList();
		//print_r($data); die;
		$academic_year_id = $this->createElement('select','academic_year_id')
							->removeDecorator('label')
							->setAttrib('class',array('form-control','chosen-select'))
						   ->setAttrib('required','required')
                        ->setRequired(true)
							->removeDecorator("htmlTag")
							->addMultiOptions(array('' => 'Select'))
							->addMultiOptions($data);
        $this->addElement($academic_year_id);
		
		
		
                $term_id = $this->createElement('select','term_id')
					->removeDecorator('label')
							->setAttrib('class',array('form-control','chosen-select'))
						   ->setAttrib('required','required')
                        ->setRequired(true)
							->addMultiOptions(array('' => 'Select'))
                                                        ->setRegisterInArrayValidator(false)
							->removeDecorator("htmlTag");
                
        $this->addElement($term_id);
		
		
		//$course_model = new Application_Model_Course();
		//$data = $course_model->getDropDownList();
		//print_r($data); die;
		$course_id = $this->createElement('select','course_id')
							->removeDecorator('label')
							->setAttrib('class',array('form-control','chosen-select'))
                                                        ->setAttrib('required','required')
                        ->setRequired(true)
							->addMultiOptions(array('' => 'Select'))
                                                        ->removeDecorator("htmlTag")
                                                        ->setRegisterInArrayValidator(false);
							//->addMultiOptions($data);
        $this->addElement($course_id);
		
		
		/* $course_model = new Application_Model_Course();
		$data = $course_model->getCoreDropDownList();
		//print_r($data); die;
		$course_id = $this->createElement('select','course_id')
							->removeDecorator('label')
							->setAttrib('class',array('form-control','chosen-select'))
						   ->setAttrib('required','required')
							->removeDecorator("htmlTag")
							->addMultiOptions(array('' => 'Select'))
							->addMultiOptions($data);
        $this->addElement($course_id); */
		
		//$StudentPortal_model = new Application_Model_StudentPortal();
		//$data = $StudentPortal_model->getDropDownList();
		$student_id = $this->createElement('select','student_id')
		              ->removeDecorator('label')
					  ->setAttrib('class',array('form-control','chosen-select'))
					  ->setAttrib('required','required')
                        ->setRequired(true)
					  ->removeDecorator("htmlTag")
                                          ->setRegisterInArrayValidator(false)
					  ->addMultiOptions(array(''=>'Select'));
					 // ->addMultiOptions($data);
		$this->addElement($student_id);
		/*
		$CreditMaster_model = new Application_Model_CreditMaster();
		$data = $CreditMaster_model->getCourseCreditDropDownList();
		//print_r($data); die;
		$credit_id = $this->createElement('select','credit_id')
							->removeDecorator('label')
							->setAttrib('class',array('form-control','chosen-select'))
						   ->setAttrib('required','required')
							->removeDecorator("htmlTag")
							->addMultiOptions(array('' => 'Select'))
							->addMultiOptions($data);
        $this->addElement($credit_id);
                 * 
                 */
		
}
	
}