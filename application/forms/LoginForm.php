<?php

class Form_LoginForm extends Zend_Form
{
	public function __construct($option = null)
	{
		//Skicka med eventuella options till superklassen
		parent::__construct($option);
		
		//Sätter namnet på formen till 'login'
		$this->setName('login');
		
		//// Skapa fälten som zend_form elements ////
	
		//username
		$username = new Zend_Form_Element_Text('username');
		$username->setLabel('Username: ')
				 ->setRequired();
				 
		//password
		$password = new Zend_Form_Element_Password('password');
		$password->setLabel('Password: ')
				 ->setRequired();
				 
		//Login button
		$login = new Zend_Form_Element_Submit('login');
		$login->setLabel('Login')
			  ->class = 'btn btn-primary';
		
		//Addera elementen till formen
		$this->addElements(array($username, $password, $login));
		$this->setMethod('post');
		$this->setAction('/authentication/login');
		
	}
}

?>