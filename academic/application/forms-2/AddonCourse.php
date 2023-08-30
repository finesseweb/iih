<?php

class Application_Form_AddonCourse extends Zend_Form {

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
        
        
        
        
        //  $sessionModel = new Application_Model_Session();
        // $data = $sessionModel->getDropDownListforExcel();
        // //print_r($data); die;
        // $session_id = $this->createElement('select', 'session_id')
        //         ->removeDecorator('label')
        //         ->setAttrib('class', array('form-control', 'chosen-select'))
        //         ->setRequired(true)
        //         ->addMultiOptions(array('' => 'Select Academic Year'))
        //         ->addMultiOptions($data)
        //         ->removeDecorator("htmlTag");
        // $this->addElement($session_id);
        
        // $Addon_model = new Application_Model_AddonCourseModel();
        // $data = $Addon_model->getAddonExcelDropDownList();
        // //print_r($data); die;
        // $course_list = $this->createElement('select', 'course_list')
        //         ->removeDecorator('label')
        //         ->setAttrib('class', array('form-control', 'chosen-select'))
        //         ->setRequired(true)
        //         ->addMultiOptions(array('' => 'Select Academic Year'))
        //         ->addMultiOptions($data)
        //         ->removeDecorator("htmlTag");
        // $this->addElement($course_list);
        
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
        $Addon_model = new Application_Model_AddonCourseModel();
        $data = $Addon_model->getDropDownList();
        //print_r($data); die;
        $addon_id = $this->createElement('select', 'addon_course_list')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select', 'chosen-select'))
                ->setRequired(true)
                ->addMultiOptions(array('' => 'Select'))
                ->addMultiOptions($data)
                ->removeDecorator("htmlTag");
        $this->addElement($addon_id);

        $deptType_model = new Application_Model_DepartmentType();
        $data = $deptType_model->getDropDownList();
        //print_r($data); die;
        $deptType_id = $this->createElement('select', 'department_type')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select', 'chosen-select'))
                ->setRequired(true)
                ->addMultiOptions(array('' => 'Select'))
                ->addMultiOptions($data)
                ->removeDecorator("htmlTag");
        $this->addElement($deptType_id);

        $name = $this->createElement('text', 'name')
                ->removeDecorator('label')->setAttrib('class', array('form-control'))
                ->setRequired(true)
                ->removeDecorator("htmlTag");
        $this->addElement($name);
        
           $code = $this->createElement('text', 'code')
                ->removeDecorator('label')->setAttrib('class', array('form-control'))
                ->setRequired(true)
                ->removeDecorator("htmlTag");
        $this->addElement($code);

        $conducted_by = $this->createElement('text', 'conductedby')
                ->removeDecorator('label')->setAttrib('class', array('form-control'))
                ->setRequired(true)
                ->removeDecorator("htmlTag");
        $this->addElement($conducted_by);

        $capacity = $this->createElement('text', 'capacity')
                ->removeDecorator('label')->setAttrib('class', array('form-control'))
                ->setRequired(true)
                ->removeDecorator("htmlTag");
        $this->addElement($capacity);

        $fee = $this->createElement('text', 'fee')
                ->removeDecorator('label')->setAttrib('class', array('form-control'))
                ->setRequired(true)
                ->removeDecorator("htmlTag");
        $this->addElement($fee);
        
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
    }

}
