<?php

class Application_Form_AddonEmployeeAllotment extends Zend_Form {

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

      
        $Academic_model = new Application_Model_AddonCourseModel();
        $data = $Academic_model->getDropDownList();
        //print_r($data); die;
        $academic_year_id = $this->createElement('select', 'addon_course_id')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setAttrib('required', 'required')->setRequired(true)
                ->removeDecorator("htmlTag")
                ->addMultiOptions(array('' => 'Select Addon Courses'))
                ->addMultiOptions($data);
        $this->addElement($academic_year_id);

        //print_r($data); die;
        
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
        
        
         $Academic_year_model = new Application_Model_AcademicYear();
        $data = $Academic_year_model->getDropDownList();
        //print_r($data); die;
        $year_id = $this->createElement('select', 'mig_academic_year')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->addMultiOptions(array('' => 'Select Academic Year'))
                ->addMultiOptions($data)
                ->removeDecorator("htmlTag");
        $this->addElement($year_id);
      
    }

}

?>