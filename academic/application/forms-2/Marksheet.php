<?php

class Application_Form_Marksheet extends Zend_Form {

    public function init() {

        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        $Department_model = new Application_Model_Department();
        $data = $Department_model->getDropDownList();
        //print_r($data); die;
        $department_id = $this->createElement('select', 'department')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setRequired(true)
                ->addMultiOptions(array('' => 'Select'))
                ->addMultiOptions($data)
                ->removeDecorator("htmlTag");
        $this->addElement($department_id);
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
        $year_id = $this->createElement('select', 'academic_year')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->addMultiOptions(array('' => 'Select Academic Year'))
                ->addMultiOptions($data)
                ->removeDecorator("htmlTag");
        $this->addElement($year_id);

        $Department_model = new Application_Model_Session();
        $data = $Department_model->getDropDownList();
        //print_r($data); die;
        $session_id = $this->createElement('select', 'session')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setRequired(true)
                ->addMultiOptions(array('' => 'Select Session'))
                ->addMultiOptions($data)
                ->removeDecorator("htmlTag");
        $this->addElement($session_id);

        $session_id = $this->createElement('select', 'stu_type')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control'))
                ->setRequired(true)
                ->addMultiOptions(array(
                    '' => 'Select Student Type',
                    '1' => 'Collegiate',
                    '2' => 'Non Collegiate'
                ))
                ->removeDecorator("htmlTag");
        $this->addElement($session_id);
        
        $declaredTerms = new Application_Model_Declaredterms();
        $data = $declaredTerms->getDropDownList();
        $term = $this->createElement('select', 'cmn_terms')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setAttrib('required', 'required')
                ->setRequired(true)
                ->removeDecorator("htmlTag")
                ->addMultiOptions(array('' => 'Select Semester'))
                ->addMultiOptions($data);
        $this->addElement($term);

    }

}
