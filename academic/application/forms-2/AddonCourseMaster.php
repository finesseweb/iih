<?php
class Application_Form_AddonCourseMaster extends Zend_Form
{
    public function init()
	
    {
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
		
						 
		$coursetype_model = new Application_Model_AddonCourseModel();
		$data = $coursetype_model->getDropDownList();
	        $ct_id = $this->createElement('select','addon_course_id')
                    ->removeDecorator('label')
                    ->setAttrib('class',array('form-control','chosen-select'))
                     ->setAttrib('required','required')  
                    ->setRequired(true)
                  ->addMultiOptions(array('' => 'Select'))
                    ->addMultiOptions($data)
                    ->removeDecorator("htmlTag");
                   
                $this->addElement($ct_id);
			
		 $ct_id1 = $this->createElement('select','addon_course_list')
                    ->removeDecorator('label')
                    ->setAttrib('class',array('form-control','select2'))
                   
                    ->setAttrib('multiple','multiple')    
                  ->addMultiOptions(array('' => 'Select'))
                    ->addMultiOptions($data)
                    ->removeDecorator("htmlTag");
                   
                $this->addElement($ct_id1);
			
		$course_code = $this->createElement('text','course_code')
                     ->removeDecorator('label')->setAttrib('class',array('form-control'))
                     ->setAttrib('required','required')
                     ->setAttrib('readonly','readonly')
                     ->setRequired(true)
                     ->removeDecorator("htmlTag");
                $this->addElement($course_code);
		 
		
       $Academic_model = new Application_Model_AcademicYear();
		$data = $Academic_model->getDropDownList();
		//print_r($data); die;
            $academic_year_id = $this->createElement('select','academic_year_id')
                    ->removeDecorator('label')
                    ->setAttrib('class',array('form-control','chosen-select'))
                    ->setAttrib('required','required')
                    ->addMultiOptions(array('' => 'Select'))
                    ->addMultiOptions($data)
                    ->removeDecorator("htmlTag");
        $this->addElement($academic_year_id);
         $academic_year_id1 = $this->createElement('select','academic_year_mig')
                    ->removeDecorator('label')
                    ->setAttrib('class',array('form-control','chosen-select'))
                  ///  ->setAttrib('required','required')
                    ->addMultiOptions(array('' => 'Select'))
                    ->addMultiOptions($data)
                    ->removeDecorator("htmlTag");
        $this->addElement($academic_year_id1);
//		
//		$course_description = $this->createElement('textarea','course_description')
//                ->removeDecorator('label')->setAttrib('class',array('form-control'))
//                ->setRequired(true)
//				->setAttrib('rows', '2')
//                ->removeDecorator("htmlTag");
//        $this->addElement($course_description);
		
		
		}
	}
		?>