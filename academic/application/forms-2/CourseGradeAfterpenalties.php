<?php
class Application_Form_CourseGradeAfterpenalties extends Zend_Form
{
    public function init()
	
    {
		
		$Academic_model = new Application_Model_Academic();
		$data = $Academic_model->getDropDownList();
		//print_r($data); die;
		$academic_id = $this->createElement('select','academic_id')
							->removeDecorator('label')
							->setAttrib('class',array('form-control','chosen-select'))
						   ->setAttrib('required','required')
                        ->setRequired(true)
							->addMultiOptions(array('' => 'Select'))
							->addMultiOptions($data)
							->removeDecorator("htmlTag");
        $this->addElement($academic_id);
        
        	
		$term_id = $this->createElement('select','term_id')
					->removeDecorator('label')
							->setAttrib('class',array('form-control','chosen-select'))
						   ->setAttrib('required','required')
                        ->setRequired(true)
							->addMultiOptions(array('' => 'Select'))
                                                        ->setRegisterInArrayValidator(false)
							->removeDecorator("htmlTag");
		$this->addElement($term_id);					
		
       
		
		}
	}
		?>