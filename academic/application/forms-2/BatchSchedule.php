<?php 
class Application_Form_BatchSchedule extends Zend_Form
{
	public function init()
	{
		
            
                 $department_master = new Application_Model_Department();
                               $department_lists = $department_master->getDropDownList(); 
                               //echo '<pre>';print_r($department_lists);exit;
			$department = $this->createElement('select','department')
							->removeDecorator('label')
							->setAttrib('class',array('form-control','chosen-select'))
							->addMultioptions(array(''=>'Select'))
							->addMultioptions($department_lists)
							->removeDecorator('htmlTag');
				$this->addElement($department);
        

	$Academic_model = new Application_Model_Session();
	$data = $Academic_model->getDropDownList();
		//print_r($data); die;
        $session_id = $this->createElement('select','session_id')
                            ->removeDecorator('label')
                            ->setAttrib('class',array('form-control','chosen-select'))
                                                        ->setAttrib('required','required')
                        ->setRequired(true)
                            ->addMultiOptions(array('' => 'Select'))
                            ->addMultiOptions($data)
                            ->removeDecorator("htmlTag");
        $this->addElement($session_id);
        

		$academic_year_id = $this->createElement('select','academic_year_id')
							->removeDecorator('label')
							->setAttrib('class',array('form-control','chosen-select'))
                                                        ->setAttrib('required','required')
                        ->setRequired(true)
							->addMultiOptions(array('' => 'Select'))
							//->addMultiOptions($data)
							->removeDecorator("htmlTag");
        $this->addElement($academic_year_id);
		
		/*$HRMModel_model = new Application_Model_HRMModel();
		$data = $HRMModel_model->getDepartments();
		$department_id = $this->createElement('select','department_id')
		                  ->removeDecorator('label')
						  ->setAttrib('class',array('form-control'))
						  ->setAttrib('required','required')
						  ->addMultiOptions(array(''=>'Select'))
						  ->addMultiOptions($data)
						   ->removeDecorator("htmlTag");
		$this->addElement($department_id);*/
        // $FeeCategory_model = new Application_Model_ScholarStructure();
        $FeeCategory_model = new Application_Model_TermMaster();
        // $data1 = $FeeCategory_model->getDropDownListOfTerms();
        $data1 = $FeeCategory_model->getDropDownList();
        // print_r($data1); exit;
        $Term_id = $this->createElement('select', 'Term_id')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setAttrib('required', 'required')
                ->setRequired(true)
                ->removeDecorator("htmlTag")
                ->addMultiOptions(array('' => 'Select'))
               // ->addMultiOptions($data1)
                ->setRegisterInArrayValidator(false);
        $this->addElement($Term_id);	
        
        
        $section = $this->createElement('select', 'section')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setAttrib('required', 'required')
                ->setRequired(true)
                ->removeDecorator("htmlTag")
                ->addMultiOptions(array('' => 'Select'))
               // ->addMultiOptions($data1)
                ->setRegisterInArrayValidator(false);
        $this->addElement($section);				
	
         $from_date = $this->createElement('text','from_date')
                ->removeDecorator('label')->setAttrib('class',array('form-control','datepicker'))
                //->setRequired(true)
              
                ->removeDecorator("htmlTag");
        $this->addElement($from_date);
		
		$to_date = $this->createElement('text','to_date')
                ->removeDecorator('label')->setAttrib('class',array('form-control','datepicker'))
               // ->setRequired(true)
                ->removeDecorator("htmlTag");
        $this->addElement($to_date);
        
        
           $version_id = $this->createElement('select', 'version_id')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setAttrib('style',array('display:none')) 
                ->removeDecorator("htmlTag")
                ->addMultiOptions(array('' => 'Select'))
                ->addMultiOptions($data1)
                ->setRegisterInArrayValidator(false);
        $this->addElement($version_id);	
        }
	}
	
