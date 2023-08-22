<?php

class Application_Form_Department extends Zend_Form {

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
        
        $hons_type = $this->createElement('text', 'hons_type')
                ->removeDecorator('label')->setAttrib('class', array('form-control'))
              
                ->setRequired(true)
                ->removeDecorator("htmlTag");
        $this->addElement($hons_type);
        
        $department_type = new Application_Model_DepartmentType();
        $data = $department_type->getDropDownList();
        $department_type = $this->createElement('select', 'department_type')
                ->removeDecorator('label')
                ->setAttrib('class',array('form-control','chosen-select'))
                  ->setAttrib('required', 'required')
            ->setRequired(true)
                 ->addMultioptions(array(''=>'Select'))
                  ->addMultioptions($data)
                
                ->removeDecorator('htmlTag');
        $this->addElement($department_type);

        $status = $this->createElement('select', 'status')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control','chosen-select'))
            ->setRequired(true)
                ->addMultioptions(array('0' => 'Active', '1' => 'Inactive'))
                ->removeDecorator('htmlTag');
        $this->addElement($status);
        
        $HRMModel_model = new Application_Model_HRMModel();
		$data = $HRMModel_model->getEmployeeIds();
		$employee_id = $this->createElement('select','employee_id')
                ->removeDecorator('label')->setAttrib('class',array('form-control','chosen-select'))
               ->setAttrib('required','required')
                        ->setRequired(true)
                ->addMultiOptions(array('' => 'Select'))
				->addMultiOptions($data)
                ->removeDecorator("htmlTag");
        $this->addElement($employee_id); 
        
        $Department_model = new Application_Model_DepartmentType();
		$data = $Department_model->getDropDownList();
		//print_r($data); die;
		$department_list = $this->createElement('select','department_list')
							->removeDecorator('label')
							->setAttrib('class',array('form-control','chosen-select'))
                            ->setAttrib('required','true')
                        ->setRequired(true)
							->addMultiOptions(array('' => 'Select'))
							->addMultiOptions($data)
							->removeDecorator("htmlTag");
                $this->addElement($department_list);
          
    }

}
