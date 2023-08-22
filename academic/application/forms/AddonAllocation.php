<?php

class Application_Form_AddonAllocation extends Zend_Form
{
public function init(){
    
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
    $addon_id = $this->createElement('select', 'addon_course_list')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select', 'chosen-select'))
                ->setRequired(true)
                ->addMultiOptions(array('' => 'Select'))
                ->addMultiOptions($data)
                ->removeDecorator("htmlTag");
    $this->addElement($addon_id);
        
    $Coursecategory_model = new Application_Model_AddonCourseMasterModel();
    $data = $Coursecategory_model->getCoreDropDownList();
    $course_id = $this->createElement('select', 'course_id')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setAttrib('required', 'required')
                ->setRequired(true)
                ->removeDecorator("htmlTag")
                ->addMultiOptions(array('' => 'Select Course'))
                ->addMultiOptions($data);
    $this->addElement($course_id);
		
    $HRMModel_model = new Application_Model_HRMModel();
    $data = $HRMModel_model->getDepartments();
    $department_id = $this->createElement('select','department_id')
                ->removeDecorator('label')->setAttrib('class',array('form-control'))
                ->setAttrib('required','required')->setRequired(true)
                ->addMultiOptions($data)
                ->removeDecorator("htmlTag");
    $this->addElement($department_id);
		
    $HRMModel_model = new Application_Model_HRMModel();
    $data = $HRMModel_model->getEmployeeIdsgrade();
		$employee_id = $this->createElement('select','employee_id')
                ->removeDecorator('label')->setAttrib('class',array('form-control','chosen-select'))
               ->setAttrib('required','required')->setRequired(true)
		->addMultiOptions($data)
                ->removeDecorator("htmlTag");
    $this->addElement($employee_id);
			
	}
	
}