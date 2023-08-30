<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 

*/class Application_Form_StudentElement extends Zend_Form {

    public function init() {
        $declaredTerms = new Application_Model_Declaredterms();
        $data = $declaredTerms->getDropDownList();
        $term = $this->createElement('select', 'cmn_terms')
            ->removeDecorator('label')
            ->setAttrib('class', array('form-control', 'chosen-select'))
            ->setAttrib('required', 'required')
            ->setRequired(true)
            ->removeDecorator("htmlTag")
            ->addMultiOptions(array('' => 'Select'))
            ->addMultiOptions($data);
        $this->addElement($term);

        $status = $this->createElement('select', 'status')
            ->removeDecorator('label')
            ->setAttrib('class', array('form-control', 'chosen-select'))
            ->setAttrib('required', 'required')
            ->setRequired(true)
            ->removeDecorator("htmlTag")
            ->addMultiOptions(array('0' => 'Incomplete'))
            ->addMultiOptions(array('1' => 'Complete'));
        $this->addElement($status);

        $Coursecategory_model = new Application_Model_Coursecategory();
        $data = $Coursecategory_model->getDropDownList();
        //print_r($data); die;
        $cc_id = $this->createElement('select', 'cc_id')
            ->removeDecorator('label')
            ->setAttrib('class', array('form-control', 'chosen-select'))
            ->setAttrib('required', 'required')
            ->setRequired(true)
            ->removeDecorator("htmlTag")
            ->addMultiOptions(array('' => 'Select'))
            ->addMultiOptions($data);
        $this->addElement($cc_id);

        $degree_model = new Application_Model_Degree();
        $data = $degree_model->getDropDownList();
        $degree_id = $this->createElement('select', 'degree_id')
            ->removeDecorator('label')
            ->setAttrib('required', 'required')
            ->setRequired(true)
            ->setAttrib('class', array('form-control', 'chosen-select'))
            ->addMultioptions(array('' => 'Select'))
            ->addMultioptions($data)
            ->removeDecorator('htmlTag');
        $this->addElement($degree_id);
    }

}
