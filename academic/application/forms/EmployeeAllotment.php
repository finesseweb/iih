<?php

class Application_Form_EmployeeAllotment extends Zend_Form {

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

        /* $HRMModel_model = new Application_Model_HRMModel();
          $data = $HRMModel_model->getEmployeeIds();
          $ea_name = $this->createElement('select','ea_name')
          ->removeDecorator('label')->setAttrib('class',array('form-control'))
          ->setAttrib('required','required')
          ->addMultiOptions(array(''=>'Select'))
          ->addMultiOptions($data)
          ->removeDecorator("htmlTag");
          $this->addElement($ea_name);

          $HRMModel_model = new Application_Model_HRMModel();
          $data = $HRMModel_model->getDesiggroupDropDownList();
          $desig_name = $this->createElement('select','desig_name')
          ->removeDecorator('label')->setAttrib('class',array('form-control'))
          ->setAttrib('required','required')
          ->addMultiOptions(array(''=>'Select'))
          ->addMultiOptions($data)
          ->removeDecorator("htmlTag");
          $this->addElement($desig_name);


          $HRMModel_model = new Application_Model_HRMModel();
          $data = $HRMModel_model->getDesignationDropDownList();
          $designation_name = $this->createElement('select','designation_name')
          ->removeDecorator('label')->setAttrib('class',array('form-control'))
          ->setAttrib('required','required')
          ->addMultiOptions(array(''=>'Select'))
          ->addMultiOptions($data)
          ->removeDecorator("htmlTag");
          $this->addElement($designation_name);

          $HRMModel_model = new Application_Model_HRMModel();
          $data = $HRMModel_model->getDepartments();
          //print_r($data);die;
          $department_name = $this->createElement('select','department_name')
          ->removeDecorator('label')->setAttrib('class',array('form-control'))
          ->setAttrib('required','required')
          ->addMultiOptions(array(''=>'Select'))
          ->addMultiOptions($data)
          ->removeDecorator("htmlTag");
          $this->addElement($department_name);

         */
        $Academic_model = new Application_Model_Academic();
        $data = $Academic_model->getDropDownList();
        //print_r($data); die;
        $academic_year_id = $this->createElement('select', 'academic_year_id')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setAttrib('required', 'required')->setRequired(true)
                ->removeDecorator("htmlTag")
                ->addMultiOptions(array('' => 'Select Academic Year'))
                ->addMultiOptions($data);
        $this->addElement($academic_year_id);

        //print_r($data); die;
        $term_id = $this->createElement('select', 'term_id')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setAttrib('required', 'required')->setRequired(true)
                ->removeDecorator("htmlTag")
                ->addMultiOptions(array('' => 'Select Term'))
                ->setRegisterInArrayValidator(false);
        $this->addElement($term_id);
        
        $mig_term_id = $this->createElement('select', 'mig_term_id')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setAttrib('required', 'required')
                ->removeDecorator("htmlTag")
                ->addMultiOptions(array('' => 'Select Migration Term'))
                ->addMultiOptions($data);
        $this->addElement($mig_term_id);
        
        $Academic_year_model = new Application_Model_AcademicYear();
        $data = $Academic_year_model->getDropDownList();
        $year_id = $this->createElement('select', 'academic_year')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setAttrib('required', 'required')
                ->setRequired(true)
                ->addMultiOptions(array('' => 'Select Year'))
                ->addMultiOptions($data)
                ->removeDecorator("htmlTag");
        $this->addElement($year_id);

        $session_model = new Application_Model_Session();
        $data = $session_model->getDropDownList();
        $session_id = $this->createElement('select', 'session')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setAttrib('required', 'required')
                ->setRequired(true)
                ->addMultiOptions(array('' => 'Select Session'))
                ->addMultiOptions($data)
                ->removeDecorator("htmlTag");
        $this->addElement($session_id);

        $department_type = new Application_Model_DepartmentType();
        $data = $department_type->getDropDownList();
        $department_type = $this->createElement('select', 'stream')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setRequired(true)
                ->addMultioptions(array('' => 'Select Stream'))
                ->addMultioptions($data)
                ->removeDecorator('htmlTag');
        $this->addElement($department_type);

        $Academic_model = new Application_Model_Academic();
        $data = $Academic_model->getDropDownList();
        //print_r($data); die;
        $mig_academic_id = $this->createElement('select', 'mig_academic_id')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setAttrib('required', 'required')
                ->setRequired(true)
                ->removeDecorator("htmlTag")
                ->addMultiOptions(array('' => 'Select Migration'))
                ->addMultiOptions($data);
        $this->addElement($mig_academic_id);
    }

}

?>