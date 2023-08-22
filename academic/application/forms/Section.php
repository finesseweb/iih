<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Application_Form_Section extends Zend_Form {

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
        
        $Academic_model = new Application_Model_Academic();
        $data = $Academic_model->getDropDownList();
        //print_r($data); die;
        $academic_id = $this->createElement('select', 'academic_year_id')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setAttrib('required', 'required')->setRequired(true)
                ->removeDecorator("htmlTag")
                ->addMultiOptions(array('' => 'Select'))
                ->addMultiOptions($data);
        $this->addElement($academic_id);

        /* 	$year = $this->createElement('select','year')
          ->removeDecorator('label')
          ->setAttrib('class',array('form-control','chosen-select'))
          ->setAttrib('required','required')
          ->removeDecorator("htmlTag")
          ->addMultiOptions(array('' => 'Select',
          '1'=>'First Year',
          '2'=>'Second Year'));
          $this->addElement($year); */

        $term_id = $this->createElement('select', 'term_id')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setAttrib('required', 'required')->setRequired(true)
                ->removeDecorator("htmlTag")
                ->addMultiOptions(array('' => 'Select'))
                ->setRegisterInArrayValidator(false);
        $this->addElement($term_id);
        
        
    $section_name = $this->createElement('text','name')
        ->removeDecorator('label')
        ->setAttrib('class',array('form-control'))
        ->setAttrib('required','required')->setRequired(true)
        ->removeDecorator("htmlTag");
        $this->addElement($section_name);
        
        $status = $this->createElement('select', 'status')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control'))
                ->setAttrib('required', 'required')->setRequired(true)
                ->removeDecorator("htmlTag")
                ->addMultiOptions(array('' => 'Select',0=>'Active',1=>'Deactive'))
                ->setRegisterInArrayValidator(false);
        $this->addElement($status);
        
        //Added by kedar
        $session_year = new Application_Model_Session();
		$data = $session_year->getDropDownList();
		//print_r($data); die;
		$session_id = $this->createElement('select','session')
            ->removeDecorator('label')
            ->setAttrib('class',array('form-control','chosen-select'))
            ->setAttrib('required','required')->setRequired(true)
            ->addMultiOptions(array('' => 'Select Session'))
            ->addMultiOptions($data)
            ->removeDecorator("htmlTag");
        $this->addElement($session_id);
        
        $Academic_year_model = new Application_Model_AcademicYear();
		$data = $Academic_year_model->getDropDownList();
		//print_r($data); die;
		$year_id = $this->createElement('select','year_id')
            ->removeDecorator('label')
            ->setAttrib('class',array('form-control','chosen-select'))
            ->setAttrib('required','required')->setRequired(true)
            ->addMultiOptions(array('' => 'Select Academic Year'))
            ->addMultiOptions($data)
            ->removeDecorator("htmlTag");
        $this->addElement($year_id);
        
    }
    

}

