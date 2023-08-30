<?php

class Application_Form_Assignment extends Zend_Form {

    public function init() {


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
        $session_model = new Application_Model_Session();
		$data = $session_model->getDropDownList();
		$session_id = $this->createElement('select','session')
							->removeDecorator('label')
							->setAttrib('class',array('form-control','chosen-select'))
                        ->setRequired(true)
                            //->setAttrib('required','required')
							//->addMultiOptions(array('' => 'Select'))
							->addMultiOptions($data)
							->removeDecorator("htmlTag");
                $this->addElement($session_id);
                
        $session_year = new Application_Model_Session();
		$data = $session_year->getDropDownList();
		//print_r($data); die;
		
        $degree_model = new Application_Model_Degree();
        $data = $degree_model->getDropDownList();
         $degree_id = $this->createElement('select', 'degree_id')
                ->removeDecorator('label')
                ->setAttrib('required', 'required')
                 ->setRequired(true)
                ->setAttrib('class', array('form-control','chosen-select'))
                 ->addMultioptions(array(''=>'Select'))
                ->addMultioptions($data)
                ->removeDecorator('htmlTag');
        $this->addElement($degree_id);
        
        $Department_model = new Application_Model_Department();
		$data = $Department_model->getDropDownList();
		//print_r($data); die;
		$department = $this->createElement('select','department')
							->removeDecorator('label')
							->setAttrib('class',array('form-control','chosen-select'))
                            ->setRequired(true)
							->addMultiOptions(array('0' => 'Select'))
							->addMultiOptions($data)
							->removeDecorator("htmlTag");
                $this->addElement($department);
                 $Department_model = new Application_Model_Session();
		$data = $Department_model->getDropDownList();
		//print_r($data); die;
		
		
		$Ge_model = new Application_Model_Ge();
		$data = $Ge_model->getDropDownList();
		//print_r($data); die;
		$Ge_id = $this->createElement('select','ge_id')
							->removeDecorator('label')
							->setAttrib('class',array('form-control','chosen-select'))
                                                       // ->setAttrib('required','required')
                            //->setRequired(true)
							->addMultiOptions(array('0' => 'Select'))
							->addMultiOptions($data)
							->removeDecorator("htmlTag");
                $this->addElement($Ge_id);
                
		$courseGroupModel = new Application_Model_Ge();
		$data = $courseGroupModel->getDropDownListForcourseGroup();
		//print_r($data); die;
		$courseGroupModel = $this->createElement('select','course_group')
							->removeDecorator('label')
							->setAttrib('class',array('form-control','chosen-select'))
                                                       // ->setAttrib('required','required')
                                //->setRequired(true)
							->addMultiOptions(array('-1' => 'Filter By Course Group'))
                            ->addMultiOptions(array('0' => 'Core Course'))
							->addMultiOptions($data)
							->removeDecorator("htmlTag");
                $this->addElement($courseGroupModel);
                
                
        $declaredTerms =  new Application_Model_Declaredterms();
        $data = $declaredTerms->getDropDownList();
           $term = $this->createElement('select', 'cmn_terms')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setAttrib('required', 'required')
                   ->setRequired(true)
                ->removeDecorator("htmlTag")
                ->addMultiOptions(array('' => 'Select'))
                   ->addMultiOptions($data);
                   $this->addElement($term);
                   
                   
                   $Coursecategory_model = new Application_Model_Coursecategory();
		$data = $Coursecategory_model->getDropDownList();
		//print_r($data); die;
                                    $cc_id = $this->createElement('select','cc_id')
							->removeDecorator('label')
							->setAttrib('class',array('form-control','chosen-select'))
						   ->setAttrib('required','required')
                                            ->setRequired(true)
							->removeDecorator("htmlTag")
							->addMultiOptions(array('' => 'Select'))
							->addMultiOptions($data);
                                      $this->addElement($cc_id);
		

		$HRMModel_model = new Application_Model_HRMModel();
		$data = $HRMModel_model->getEmployeeIds();
		$employee_id = $this->createElement('select','employee_id')
                ->removeDecorator('label')->setAttrib('class',array('form-control','chosen-select'))
               ->setAttrib('required','required')
                        ->setRequired(true)
                ->addMultiOptions(array('0' => 'Select'))
				->addMultiOptions($data)
                ->removeDecorator("htmlTag");
        $this->addElement($employee_id); 
        
        
        
        
        
        
        
        
        $document_type = $this->createElement('select', 'document_type')
            ->removeDecorator('label')
            ->setAttrib('class', array('form-control', 'chosen-select'))
            ->setAttrib('required', 'required')
            ->setRequired(true)
            ->removeDecorator("htmlTag")
            ->addMultiOptions(array('' => 'Select',
            '1' => 'Assignments',
            '2' => 'Course Materials'));
        $this->addElement($document_type);


        $status = $this->createElement('select', 'status')
            ->removeDecorator('label')
            ->setAttrib('class', array('form-control', 'chosen-select'))
            ->setAttrib('required', 'required')
            ->setRequired(true)
            ->removeDecorator("htmlTag")
            ->addMultiOptions(array(
            '1' => 'Active',
            '2' => 'Inactive'));
        $this->addElement($status);

        $document_title = $this->createElement('text', 'document_title')
            ->removeDecorator('label')->setAttrib('class', array('form-control'))
            ->setAttrib('required', 'required')
            ->setRequired(true)
            ->removeDecorator("htmlTag");
        $this->addElement($document_title);

        $remarks = $this->createElement('textarea', 'remarks')
            ->removeDecorator('label')->setAttrib('class', array('form-control'))
            //->setRequired(true)
            ->setAttrib('rows', '2')
            ->removeDecorator("htmlTag");
        $this->addElement($remarks);

        $assignment_due = $this->createElement('text', 'due_date')
            ->removeDecorator('label')->setAttrib('class', array('form-control', 'datepicker'))
            // ->setAttrib('required', 'required')
            //->setAttrib(array('value', date('d-m-Y h:s:a')))
            ->removeDecorator("htmlTag");
        $this->addElement($assignment_due);
    }

}
