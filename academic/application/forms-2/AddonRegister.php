<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Form_AddonRegister extends Zend_Form {

    public function init() {


      
      
        
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

    $Addon_model = new Application_Model_AddonCourseModel();
    $data = $Addon_model->getDropDownList();
    
    $addon_id = $this->createElement('select', 'addon_course_list')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setRequired(true)
                ->addMultiOptions(array('' => 'Select'))
                ->addMultiOptions($data)
                ->removeDecorator("htmlTag");
    $this->addElement($addon_id);
    
    }

}
