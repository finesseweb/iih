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
                 ->addMultioptions(array('1'=>'Exam Fees','2'=>'Tuition Fees'))
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
        
    }
}