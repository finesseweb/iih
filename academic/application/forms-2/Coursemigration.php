<?php

class Application_Form_Coursemigration extends Zend_Form {

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
        $year_id = $this->createElement('select', 'academic_year_id')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'select2'))
                
                ->setAttrib('multiple', 'multipe')
                ->addMultiOptions(array('' => 'Select Academic Year'))
                ->addMultiOptions($data)
                ->removeDecorator("htmlTag");
        $this->addElement($year_id);

        $declaredTerms = new Application_Model_Declaredterms();
        $data = $declaredTerms->getDropDownList();
        $term = $this->createElement('select', 'term_id')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'select2'))
                ->setAttrib('multiple', 'multipe')
                ->removeDecorator("htmlTag")
                ->addMultiOptions(array('' => 'Select Semester'))
                ->addMultiOptions($data);
        $this->addElement($term);


      $Academic_model = new Application_Model_Academic();
		$data = $Academic_model->getDropDownList();
		//print_r($data); die;
		$mig_academic_id = $this->createElement('select','mig_academic_id')
							->removeDecorator('label')
							->setAttrib('class',array('form-control','select2'))
						   ->setAttrib('required','required')
						   ->setAttrib('multiple', 'multipe')
                        ->setRequired(true)
							->removeDecorator("htmlTag")
							->addMultiOptions(array('' => 'Select'))
							->addMultiOptions($data);
        $this->addElement($mig_academic_id);

        $declaredTerms = new Application_Model_Declaredterms();
        $data = $declaredTerms->getDropDownList();
        $term = $this->createElement('select', 'mig_term_id')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'select2'))
                ->setAttrib('multiple', 'multipe')
                ->removeDecorator("htmlTag")
                ->addMultiOptions(array('' => 'Select Semester'))
                ->addMultiOptions($data);
        $this->addElement($term);
        $session_year = new Application_Model_Session();
        $data = $session_year->getDropDownList();
        //print_r($data); die;
        $session_id = $this->createElement('select', 'session')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setAttrib('required', 'required')->setRequired(true)
                ->addMultiOptions(array('' => 'Select Session'))
                ->addMultiOptions($data)
                ->removeDecorator("htmlTag");
        $this->addElement($session_id);
   
    }


}

?>