<?php

class Application_Form_ValueAddedCourse extends Zend_Form {

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
        
        
        
        
          $sessionModel = new Application_Model_Session();
         $data = $sessionModel->getDropDownList();
         //print_r($data); die;
         $session_id = $this->createElement('select', 'session_id')
                 ->removeDecorator('label')
                 ->setAttrib('class', array('form-control', 'chosen-select'))
                 ->setRequired(true)
                 ->addMultiOptions(array('' => 'Select Session '))
                 ->addMultiOptions($data)
                 ->removeDecorator("htmlTag");
         $this->addElement($session_id);
        
        $session_id = $this->createElement('select', 'session_id_mig')
                 ->removeDecorator('label')
                 ->setAttrib('class', array('form-control', 'chosen-select'))
                 ->setRequired(true)
                 ->addMultiOptions(array('' => 'Select Session '))
                 ->addMultiOptions($data)
                 ->removeDecorator("htmlTag");
         $this->addElement($session_id);
        
         $Academic_year_model = new Application_Model_AcademicYear();
        $data = $Academic_year_model->getDropDownList();
        //print_r($data); die;
        $year_id = $this->createElement('select', 'academic_year')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setRequired(true)
                ->addMultiOptions(array('' => 'Select Academic Year'))
                ->addMultiOptions($data)
                ->removeDecorator("htmlTag");
        $this->addElement($year_id);
        
        
        $year_id = $this->createElement('select', 'academic_year_mig')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setRequired(true)
                ->addMultiOptions(array('' => 'Select Academic Year'))
                ->addMultiOptions($data)
                ->removeDecorator("htmlTag");
        $this->addElement($year_id);
        
     $semester_model = new Application_Model_Declaredterms();
        $data = $semester_model->getDropDownList();
        //print_r($data); die;
        $semester = $this->createElement('select', 'semester')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setRequired(true)
                ->addMultiOptions(array('' => 'Select Semester'))
                ->addMultiOptions($data)
                ->removeDecorator("htmlTag");
        $this->addElement($semester);
        
        
        
        
        $name = $this->createElement('text', 'course_name')
                ->removeDecorator('label')->setAttrib('class', array('form-control'))
                ->setRequired(true)
                ->removeDecorator("htmlTag");
        $this->addElement($name);
        
           $code = $this->createElement('text', 'course_code')
                ->removeDecorator('label')->setAttrib('class', array('form-control'))
                ->setRequired(true)
                ->removeDecorator("htmlTag");
        $this->addElement($code);
        
         $desc= $this->createElement('text', 'course_description')
                ->removeDecorator('label')->setAttrib('class', array('form-control'))
                ->setRequired(true)
                ->removeDecorator("htmlTag");
        $this->addElement($desc);

        $conducted_by = $this->createElement('text', 'conductedby')
                ->removeDecorator('label')->setAttrib('class', array('form-control'))
                //->setRequired(true)
                ->removeDecorator("htmlTag");
        $this->addElement($conducted_by);

        $capacity = $this->createElement('text', 'capacity')
                ->removeDecorator('label')->setAttrib('class', array('form-control'))
                ->setRequired(true)
                ->removeDecorator("htmlTag");
        $this->addElement($capacity);

        
        
        $tot_credit = $this->createElement('text', 'tot_credit')
                ->removeDecorator('label')->setAttrib('class', array('form-control'))
                ->setRequired(true)
                ->removeDecorator("htmlTag");
        $this->addElement($tot_credit);

        $status = $this->createElement('select', 'status')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control'))
                ->addMultioptions(array('0' => 'Active', '1' => 'Inactive'))
                ->removeDecorator('htmlTag');
        $this->addElement($status);
        
        
        $count = $this->createElement('select', 'countable')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control'))
                ->addMultioptions(array('0' => 'Yes', '1' => 'No'))
                ->removeDecorator('htmlTag');
        $this->addElement($count);
    }

}
