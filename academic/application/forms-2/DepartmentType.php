<?php

class Application_Form_DepartmentType extends Zend_Form {

    public function init() {
 if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
//       // echo $token;
        $degree_model = new Application_Model_Degree();
        $data = $degree_model->getDropDownList();
        $degree_id = $this->createElement('select', 'degree_id')
                ->removeDecorator('label')
                ->setAttrib('required', 'required')
                ->setRequired(true)
                ->setAttrib('class',array('form-control','chosen-select'))
                 ->addMultioptions(array(''=>'--select--'))
                ->addMultioptions($data)
                ->removeDecorator('htmlTag');
        $this->addElement($degree_id);
        
        $desciption = $this->createElement('text', 'description')
                ->removeDecorator('label')->setAttrib('class', array('form-control'))
                ->setAttrib('required', 'required')
                ->setRequired(true)
                ->removeDecorator("htmlTag");
        $this->addElement($desciption);
        
        $department = $this->createElement('text', 'department')
                ->removeDecorator('label')->setAttrib('class', array('form-control'))
                ->setAttrib('required', 'required')
                ->setRequired(true)
                ->removeDecorator("htmlTag");
        $this->addElement($department);
        
         $csrftoken = $this->createElement('hidden', 'csrftoken')
                ->removeDecorator('label')->setAttrib('class', array('form-control'))
                ->setAttrib('required', 'required')
                ->setRequired(true)
                ->setValue($token)
                ->removeDecorator("htmlTag");
        $this->addElement($csrftoken);
        
     $Department_model = new Application_Model_Session();
        $data = $Department_model->getDropDownList();
        //print_r($data); die;
        $session_id = $this->createElement('select', 'session_id')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                 ->setAttrib('required', 'required')
                ->setRequired(true)
                ->addMultiOptions(array('' => 'Select Session'))
                ->addMultiOptions($data)
                ->removeDecorator("htmlTag");
        $this->addElement($session_id);
        
        $status = $this->createElement('select', 'status')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control','chosen-select'))
            ->setRequired(true)
                ->addMultioptions(array('0' => 'Active', '1' => 'Inactive'))
                ->removeDecorator('htmlTag');
        $this->addElement($status);
        

          
    }

}
