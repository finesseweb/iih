<?php

class Application_Form_AddonCourses extends Zend_Form {

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

       $Coursecategory_model = new Application_Model_AddonCourseMasterModel();
        $data = $Coursecategory_model->getDropDownList();
        $course_id = $this->createElement('select', 'course_id')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setAttrib('required', 'required')
                ->setRequired(true)
                ->removeDecorator("htmlTag")
                ->addMultiOptions(array('' => 'Select Course'))
                ->addMultiOptions($data);
        $this->addElement($course_id);
        
        $count_id = $this->createElement('select','count_id')
			->removeDecorator('label')
			->setAttrib('class',array('form-control','chosen-select'))
			->setAttrib('required','required')
                        ->setRequired(true)
			->removeDecorator("htmlTag")
			->addMultiOptions(array(0 => 'YES',1=>'NO'));
        $this->addElement($count_id);
                

       $CreditMaster_model = new Application_Model_CreditMaster();
		$data = $CreditMaster_model->getCourseCreditDropDownListNew();
		//print_r($data); die;
		$credit_id = $this->createElement('select','credit_id')
		->removeDecorator('label')
		->setAttrib('class',array('form-control','chosen-select'))
		->setAttrib('required','required')
                ->setRequired(true)
		->removeDecorator("htmlTag")
		->addMultiOptions(array('' => 'Select'))
		->addMultiOptions($data);
        $this->addElement($credit_id);
    }

}
