<?php

/* 
    Author: Kedar Kumar
    Summary: This Form is used to handle Online Entrance Exam Multi Step Form
    Date: 23 Oct. 2019
*/
class Application_Form_MultiStepEntranceExamForm extends Zend_Form
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
        
        $session_model = new Application_Model_Session();
		$data = $session_model->getDropDownList();
		$session_id = $this->createElement('Select','session')
							->removeDecorator('label')
							->setAttrib('class',array('form-control','chosen-select'))
                            //->setAttrib('required','required')
							->addMultiOptions(array('' => 'Select'))
							->addMultiOptions($data)
                            
                           
							->removeDecorator("htmlTag");
                $this->addElement($session_id);
        $degree_model = new Application_Model_Degree();
        $data = $degree_model->getDropDownListBED();
        $degree_id = $this->createElement('select', 'degree_id')
                ->removeDecorator('label')
                ->setAttrib('required', 'required')->setRequired(true)
                ->setAttrib('class', array('form-control','chosen-select'))
                ->addMultioptions(array(''=>'Select'))
                ->addMultioptions($data)
                ->removeDecorator('htmlTag');
        $this->addElement($degree_id);
        $department_type_model = new Application_Model_DepartmentType();
        $data = $department_type_model->getDepartmentType();
        $department_type = $this->createElement('select', 'course')
                ->removeDecorator('label')
                ->setAttrib('required', 'required')->setRequired(true)
                ->setAttrib('class', array('form-control','chosen-select'))
                ->addMultioptions(array(''=>'Select'))
                ->addMultioptions($data)
                ->removeDecorator('htmlTag');
        $this->addElement($department_type);
        //Added: 07 o1ct 2020
        $Academic_year_model = new Application_Model_AcademicYear();
		$data = $Academic_year_model->getDropDownList1();
		//print_r($data); die;
		$year_id = $this->createElement('select','academic_year_list')
                    ->removeDecorator('label')
                    ->setAttrib('class',array('form-control','chosen-select'))
                    ->setAttrib('required','required')->setRequired(true)

                    ->addMultiOptions(array('' => 'Select'))
                    ->addMultiOptions($data)
                    ->removeDecorator("htmlTag");
        $this->addElement($year_id);
		
		
	 $applicant_name = $this->createElement('text', 'applicant_name');
            $applicant_name->removeDecorator('label')->setAttrib('class', array('form-control'));
            $applicant_name->setAttrib('required', 'required')->setRequired(true);
            
            $applicant_name->setAttrib('data-toggle', 'albphabets');
            $applicant_name->setAttrib('readonly', 'readonly');
            $applicant_name->setAttrib('autocomplete', 'off');
            $applicant_name->removeDecorator("htmlTag");
        $this->addElement($applicant_name);
        
        $email_id = $this->createElement('text', 'email_id');
                $email_id->removeDecorator('label')->setAttrib('class', array('form-control'));
                $email_id->setAttrib('required', 'required')->setRequired(true);
                 $email_id->setAttrib('readonly', 'readonly');
                $email_id->setAttrib('autocomplete', 'off');
                $email_id->removeDecorator("htmlTag");
        $this->addElement($email_id);
        
        $phone = $this->createElement('text', 'phone_number')
                ->removeDecorator('label')->setAttrib('class', array('form-control'));
                $phone->setAttrib('required', 'required')->setRequired(true);
                $phone->setAttrib('data-toggle', 'number');
                 $phone->setAttrib('readonly', 'readonly');
                $phone->setAttrib('autocomplete', 'off');
                $phone->removeDecorator("htmlTag");
        $this->addElement($phone);	
		
		
		$application_no = $this->createElement('text', 'application_no')
                ->removeDecorator('label')->setAttrib('class', array('form-control'));
                $application_no->setAttrib('required', 'required')->setRequired(true);
                $application_no->setAttrib('readonly', 'readonly');
                
                $application_no->setAttrib('autocomplete', 'off');
                $application_no->removeDecorator("htmlTag");
        $this->addElement($application_no);	
		
		$password = $this->createElement('text', 'password')
                ->removeDecorator('label')->setAttrib('class', array('form-control'));
                $phone->setAttrib('required', 'required')->setRequired(true);
                $phone->setAttrib('data-toggle', 'number');
                
                $phone->setAttrib('autocomplete', 'off');
                $phone->removeDecorator("htmlTag");
        $this->addElement($password);	
		
		
    }
	
}
?>

