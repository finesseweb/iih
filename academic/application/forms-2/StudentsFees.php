<?php
class Application_Form_StudentsFees extends Zend_Form
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
        
        $session_year = new Application_Model_Session();
		$data = $session_year->getDropDownList();
        $session_id = $this->createElement('select','session')
							->removeDecorator('label')
							->setAttrib('class',array('form-control','chosen-select'))
							->setAttrib('multiple','multiple')
                            ->setAttrib('required','required')->setRequired(true)
							->addMultiOptions(array('' => 'Session'))
							->addMultiOptions($data)
							->removeDecorator("htmlTag");
        $this->addElement($session_id);
        $Academic_year_model = new Application_Model_AcademicYear();
		$data = $Academic_year_model->getDropDownList();
		//print_r($data); die;
		$year_id = $this->createElement('select','academic_year')
							->removeDecorator('label')
							->setAttrib('class',array('form-control','chosen-select'))
                            ->setAttrib('required','required')->setRequired(true)
           
							->addMultiOptions(array('' => 'Academic Year'))
							->addMultiOptions($data)
							->removeDecorator("htmlTag");
                $this->addElement($year_id);
        
		$Academic_model = new Application_Model_Academic();
		$data = $Academic_model->getDropDownList();
		//print_r($data); die;
		$academic_year_id = $this->createElement('select','academic_year_id')
							->removeDecorator('label')
							->setAttrib('class',array('form-control','chosen-select'))
						   ->setAttrib('required','required')->setRequired(true)
							->removeDecorator("htmlTag")
							->addMultiOptions(array('' => 'Batch'))
							->addMultiOptions($data);
        $this->addElement($academic_year_id);
        
		$Academic_model = new Application_Model_Academic();
		$data = $Academic_model->getDropDownList();
		//print_r($data); die;
		$currentBatch = $this->createElement('select','academic_id')
							->removeDecorator('label')
							->setAttrib('class',array('form-control','chosen-select'))
						   ->setAttrib('required','required')->setRequired(true)
							->removeDecorator("htmlTag")
							->addMultiOptions(array('' => 'Batch'))
							->addMultiOptions($data);
        $this->addElement($currentBatch);
        
        $department_type = new Application_Model_TermMaster();
        $data = $department_type->getDropDownList();
        $department_type = $this->createElement('select', 'term_id')
                ->removeDecorator('label')
                ->setAttrib('class',array('form-control','chosen-select'))
            ->setRequired(true)
                 ->addMultioptions(array(''=>'Term'))
                  ->addMultioptions($data)
                
                ->removeDecorator('htmlTag');
        $this->addElement($department_type);
        
        
}
}
    ?>