<?php
class Application_Form_FeeCollection extends Zend_Form {
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
		
		$Department_model = new Application_Model_Session();
        $data = $Department_model->getDropDownList();
        //print_r($data); die;
        $session_id = $this->createElement('select', 'session_id')
                ->removeDecorator('label')
                ->setAttrib('class', array('form-control', 'chosen-select'))
                ->setRequired(true)
                ->addMultiOptions(array('' => 'Select Session'))
                ->addMultiOptions($data)
                ->removeDecorator("htmlTag");
        $this->addElement($session_id);
	}
}
?>