<?php

class Application_Form_FeeCategory extends Zend_Form
{
	public function init()
	{
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
         //To add academic year id
        $Academic_year_model = new Application_Model_AcademicYear();
		$data = $Academic_year_model->getDropDownList();
		//print_r($data); die;
		$year_id = $this->createElement('select','academic_year')
                    ->removeDecorator('label')
                    ->setAttrib('class',array('form-control','chosen-select'))
                    ->setAttrib('required','required')
                        ->setRequired(true)

                    ->addMultiOptions(array('' => 'Select'))
                    ->addMultiOptions($data)
                    ->removeDecorator("htmlTag");
        $this->addElement($year_id);
		
        $Academic_year_model = new Application_Model_AcademicYear();
		$data = $Academic_year_model->getDropDownList();
		//print_r($data); die;
		$year_id = $this->createElement('select','mig_academic_year')
                    ->removeDecorator('label')
                    ->setAttrib('class',array('form-control','chosen-select'))
                    ->setAttrib('required','required')
                        ->setRequired(true)

                    ->addMultiOptions(array('' => 'Select'))
                    ->addMultiOptions($data)
                    ->removeDecorator("htmlTag");
        $this->addElement($year_id);
		
	 $degree_model = new Application_Model_Degree();
        $data = $degree_model->getDropDownList();
         $degree_id = $this->createElement('select', 'degree_id')
                ->removeDecorator('label')
                ->setAttrib('required', 'required')->setRequired(true)
                 ->setRegisterInArrayValidator(false)
                ->setAttrib('class', array('form-control'))
                 ->addMultioptions(array(''=>'--select--'))
                ->addMultioptions($data)
                ->removeDecorator('htmlTag');
        $this->addElement($degree_id);
        
          $accname = new Application_Model_Account();
	   $data =  $accname->getDropDownList();
	      $fund_id = $this->createElement('select', 'fund_type')
                ->removeDecorator('label')
                ->setAttrib('required', 'required')->setRequired(true)
                ->setAttrib('class', array('form-control'))
                 ->addMultioptions(array(''=>'--select--'))
                ->addMultioptions($data)
                ->removeDecorator('htmlTag');
        $this->addElement($fund_id);
        
      
	    $Department_model = new Application_Model_Session();
		$data = $Department_model->getDropDownList();
		//print_r($data); die;
		$session_id = $this->createElement('select','session')
							->removeDecorator('label')
							->setAttrib('class',array('form-control','chosen-select'))
                                                        ->setAttrib('required','required')->setRequired(true)
							//->addMultiOptions(array('' => 'Select'))
							->addMultiOptions($data)
							->removeDecorator("htmlTag");
                $this->addElement($session_id);
                
                    $Department_model = new Application_Model_DepartmentType();
		$data = $Department_model->getDropDownList();
		//print_r($data); die;
		$dept_id = $this->createElement('select','dept_id')
							->removeDecorator('label')
                            ->setRegisterInArrayValidator(false)
							->setAttrib('class',array('form-control','chosen-select'))
                                                        ->setAttrib('required','required')->setRequired(true)
							//->addMultiOptions(array('' => 'Select'))
							->addMultiOptions($data)
							->removeDecorator("htmlTag");
                $this->addElement($dept_id);
                
                $session_model = new Application_Model_Session();
		$data = $session_model->getDropDownList();
		//print_r($data); die;
		$session_id = $this->createElement('select','mig_session')
							->removeDecorator('label')
							->setAttrib('class',array('form-control','chosen-select'))
                                                        ->setAttrib('required','required')->setRequired(true)
							//->addMultiOptions(array('' => 'Select'))
							->addMultiOptions($data)
							->removeDecorator("htmlTag");
                $this->addElement($session_id);
				
				
		//$cast_wise= $this->createElement('select','cast_wise')
		//	->removeDecorator('label')
		//	->setAttrib('class',array('form-control','chosen-select'))
         //   ->setAttrib('required','required')->setRequired(true)
		//	->addMultiOptions(array('' => 'Select','1'=>'No','2'=>'Yes'))
			
		//	->removeDecorator("htmlTag");
       // $this->addElement($cast_wise);		


///////$caste_category = $this->createElement('select', 'caste_category')
    //            ->removeDecorator('label')
     //           ->setAttrib('class', array('form-control'))
                //->setAttrib('required', 'required')->setRequired(true)
       //         ->removeDecorator("htmlTag")
       //         ->addMultiOptions(array(
        //                'General' => 'General',
         //               'EWS' => 'EWS',
         //               'BC-1(EBC)' => 'BC-1(EBC)',
         //               'BC-2(OBC)' => 'BC-2(OBC)',
          //              'SC' => 'SC',
          //              'ST' => 'ST'));
       // $this->addElement($caste_category);		
	
	}
	
}