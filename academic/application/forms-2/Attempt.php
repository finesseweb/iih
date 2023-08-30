<?php

class Application_Form_Attempt extends Zend_Form {

    public function init() {

        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        
        $department_id = $this->createElement('select', 'sem')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setRequired(true)
                ->addMultiOptions(array('' => 'Select','t1'=>'Sem 1','t2'=>'Sem 2','t3'=>'Sem 3','t4'=>'Sem 4','t5'=>'Sem 5','t6'=>'Sem 6'))
                //->addMultiOptions($data)
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


       $capacity = $this->createElement('text', 'last_attempt_year')
                ->removeDecorator('label')->setAttrib('class', array('form-control'))
                ->setRequired(true)
                ->removeDecorator("htmlTag");
        $this->addElement($capacity);

        
    }

}
