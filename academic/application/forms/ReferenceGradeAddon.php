<?php

class Application_Form_ReferenceGradeAddon extends Zend_Form
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
		
   $flag= $this->createElement('text', 'flag')
                ->removeDecorator('label')->setAttrib('class', array('form-control'))
                ->setAttrib('required', 'required')
                ->setRequired(true)
                ->setValue($ques_no)
                ->removeDecorator("htmlTag");
        $this->addElement($flag);
      
	
	}
	
}