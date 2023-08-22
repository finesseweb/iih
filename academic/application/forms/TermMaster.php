<?php

class Application_Form_TermMaster extends Zend_Form {

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
        $Academic_year_model = new Application_Model_AcademicYear();
		$data1 = $Academic_year_model->getDropDownList();
		//print_r($data); die;
		$years_id = $this->createElement('select','academic_year')
                    ->removeDecorator('label')
                    ->setAttrib('class',array('form-control','chosen-select'))
                   // ->setAttrib('required','required')
                        ->setRequired(true)

                    ->addMultiOptions(array('' => 'Select'))
                    ->addMultiOptions($data1)
                    ->removeDecorator("htmlTag");
        $this->addElement($years_id);
        $session_model = new Application_Model_Session();
		$data2 = $session_model->getDropDownList();
		$session_id = $this->createElement('select','session')
							->removeDecorator('label')
							->setAttrib('class',array('form-control','chosen-select'))
                      //  ->setRequired(true)
                            //->setAttrib('required','required')
							//->addMultiOptions(array('' => 'Select'))
							->addMultiOptions($data2)
							->removeDecorator("htmlTag");
                $this->addElement($session_id);
        $Academic_model = new Application_Model_Academic();
        $data3 = $Academic_model->getDropDownList();
        //print_r($data); die;
        $academic_id = $this->createElement('select', 'academic_year_id')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setAttrib('required', 'required')->setRequired(true)
                ->removeDecorator("htmlTag")
                ->addMultiOptions(array('' => 'Select'))
                ->addMultiOptions($data3);

        $this->addElement($academic_id);
        
     $declaredTerms =  new Application_Model_Declaredterms();
        $data4 = $declaredTerms->getDropDownList();
           $term = $this->createElement('select', 'cmn_terms')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setAttrib('required', 'required')->setRequired(true)
                ->removeDecorator("htmlTag")
                ->addMultiOptions(array('' => 'Select'))
                   ->addMultiOptions($data4);
                   $this->addElement($term);
        
        
        $term_name = $this->createElement('textarea', 'term_name')
                ->removeDecorator('label')->setAttrib('class', array('form-control'))
                ->setRequired(true)
                ->setAttrib('rows', '2')
                ->removeDecorator("htmlTag");
        $this->addElement($term_name);

        $start_date = $this->createElement('text', 'start_date')
                ->removeDecorator('label')->setAttrib('class', array('form-control'))
                ->setRequired(true)
                //->setAttrib('rows', '2')
                ->removeDecorator("htmlTag");
        $this->addElement($start_date);


        $end_date = $this->createElement('text', 'end_date')
                ->removeDecorator('label')->setAttrib('class', array('form-control'))
                ->setRequired(true)
                //->setAttrib('rows', '2')
                ->removeDecorator("htmlTag");
        $this->addElement($end_date);

        $term_description = $this->createElement('textarea', 'term_description')
                ->removeDecorator('label')->setAttrib('class', array('form-control'))
                ->setRequired(true)
                ->setAttrib('rows', '2')
                ->removeDecorator("htmlTag");
        $this->addElement($term_description);


        $year_drop_down = new Application_Model_Year();
        $year_arr = $year_drop_down->getDropDownList();
        $year_id = $this->createElement('select', 'year_id')
                ->removeDecorator('label')->setAttrib('class', array('form-control'))
                ->setRequired('required', 'required')
                ->addMultiOptions($year_arr)
                ->removeDecorator("htmlTag");
        $this->addElement($year_id);

        $tot_no_of_credits = $this->createElement('text', 'tot_no_of_credits')
                ->removeDecorator('label')->setAttrib('class', array('form-control'))
                ->setRequired(true)
                ->removeDecorator("htmlTag");
        $this->addElement($tot_no_of_credits);
    }

}
