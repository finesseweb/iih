<?php

class Application_Form_Notpromotedreport extends Zend_Form {

 public function init() {
        $year_model = new Application_Model_AcademicYear();
        $data = $year_model->getDropDownList();
        //print_r($data); die;
        $academic_id = $this->createElement('select', 'academic_year')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setAttrib('required', 'required')->setRequired(true)
                ->removeDecorator("htmlTag")
                ->addMultiOptions(array('' => 'Select Academic Year'))
                ->addMultiOptions($data);
        $this->addElement($academic_id);
       
        $Department_model = new Application_Model_Department();
        $data = $Department_model->getDropDownList();
        //print_r($data); die;
        $department = $this->createElement('select', 'department')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'select2'))
                ->setAttrib('multiple', 'multipe')
                //   ->setAttrib('required','required')
                ->addMultiOptions(array('0' => 'Select Department'))
                ->addMultiOptions($data)
                ->removeDecorator("htmlTag");
        $this->addElement($department);

        $declaredTerms = new Application_Model_Declaredterms();
        $data = $declaredTerms->getDropDownList();
        $term = $this->createElement('select', 'cmn_terms')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'select2'))
                ->setAttrib('multiple', 'multipe')
                ->setAttrib('required', 'required')->setRequired(true)
                ->removeDecorator("htmlTag")
                ->addMultiOptions(array('' => 'Select Semester'))
                ->addMultiOptions($data);
        $this->addElement($term);



        $session_year = new Application_Model_Session();
        $data = $session_year->getDropDownList();
        //print_r($data); die;
        $session_id = $this->createElement('select', 'session')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'select2'))
                ->setAttrib('multiple', 'multipe')
                ->setAttrib('required', 'required')->setRequired(true)
                ->addMultiOptions(array('' => 'Select Session'))
                ->addMultiOptions($data)
                ->removeDecorator("htmlTag");
        $this->addElement($session_id);
   
    }


}

?>