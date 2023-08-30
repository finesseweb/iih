<?php
class Application_Form_Selection extends Zend_Form
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
        
         $fee_waive = $this->createElement('select', 'fee_wave')
                ->removeDecorator('label')
                ->setAttrib('multiple', 'multiple')
                ->setAttrib('required', 'required')->setRequired(true)
                ->setAttrib('class', array('form-control select2'))
                 ->addMultioptions(array('1'=>'Col Exam Fees','2'=>'Non-col Exam Fees','3'=>'Semester Fees'))
                ->removeDecorator('htmlTag');
        $this->addElement($fee_waive);
        
   
    
        $selected_student = $this->createElement('select', 'selected_student')
                ->removeDecorator('label')
                ->setAttrib('multiple', 'multiple')
                ->setAttrib('required', 'required')->setRequired(true)
                ->setAttrib('class', array('form-control select2'))
                 ->addMultioptions(array(''=>'--select--'))
                ->removeDecorator('htmlTag');
        $this->addElement($selected_student);
        
    
       $declaredTerms =  new Application_Model_Declaredterms();
        $data = $declaredTerms->getDropDownList();
         $term_id = $this->createElement('select','term_id')
                    ->removeDecorator('label')
                     ->setAttrib('class',array('form-control','chosen-select'))
                     ->setAttrib('required','required')->setRequired(true)
                     ->setAttrib('multiple','multiple')
                     ->removeDecorator("htmlTag")
                     ->addMultiOptions(array(''=>'Select'))
                 ->addMultiOptions($data);
        $this->addElement($term_id);
        $remarks = $this->createElement('text', 'remarks')
                ->removeDecorator('label')->setAttrib('class', array('form-control'))
                ->removeDecorator("htmlTag");
        $this->addElement($remarks);     
        $Academic_year_model = new Application_Model_AcademicYear();
        $data = $Academic_year_model->getDropDownList();
        //print_r($data); die;
        $year_id = $this->createElement('select', 'academic_year_list')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                //->setAttrib('required','required')->setRequired(true)
                ->addMultiOptions(array('' => 'Select Academic Year'))
                ->addMultiOptions($data)
                ->removeDecorator("htmlTag");
        $this->addElement($year_id);
        
        
        $session_year = new Application_Model_Session();
        $data = $session_year->getDropDownList();
        //print_r($data); die;
        $session_id = $this->createElement('select', 'session')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                //->setAttrib('required','required')->setRequired(true)
                ->addMultiOptions(array('' => 'Select Session'))
                ->addMultiOptions($data)
                ->removeDecorator("htmlTag");
        $this->addElement($session_id);
        
        $degree_model = new Application_Model_Degree();
        $data = $degree_model->getDropDownList();
        $degree_id = $this->createElement('select', 'degree_id')
                ->removeDecorator('label')
                ->setAttrib('required', 'required')->setRequired(true)
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->addMultioptions(array('' => 'select Degree'))
                ->addMultioptions($data)
                ->removeDecorator('htmlTag');
        $this->addElement($degree_id);
        
         $Department_model = new Application_Model_Academic();
        $data = $Department_model->getDropDownList();
        //print_r($data); die;
        $department = $this->createElement('select', 'academic_id')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                //->setAttrib('required','required')
                ->addMultiOptions(array('' => 'Filter by Department'))
                ->addMultiOptions($data)
                ->removeDecorator("htmlTag");
        $this->addElement($department);
}
}