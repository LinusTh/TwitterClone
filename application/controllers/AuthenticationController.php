<?php

class AuthenticationController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction()
    {
        //Om det redan finns en instance så har användaren redan loggat in
		if(Zend_Auth::getInstance()->hasIdentity())
		{
			$this->_redirect('/tweets/mytweets');
		}
	
		//Skapa en LoginForm
		$form = new Form_LoginForm();
	
		//Vi kollar hur användaren kom hit, om det är via POST så betyder det att användaren
		//tryckte på login-knappen
		$request = $this->getRequest();
		if($request->isPost())
		{
			//Om värdena som skickas med i POST är valida enligt $form så kör vi authenticate
			if($form->isValid($this->_request->getPost()))
			{
				//Fixa en ny authAdapter
				$authAdapter = $this->getAuthAdapter();
				
				//Plocka variablerna från formen
				$username = $form->getValue('username');
				$password = md5($form->getValue('password'));
				
				//Stoppa in variablerna i adaptern
				$authAdapter->setIdentity($username)
							->setCredential($password);
				
				//För själva authenticate:andet behöver vi en zend_auth instance
				$auth = Zend_Auth::getInstance();
				//authenticate-metoden tar emot adaptern med all information
				$result = $auth->authenticate($authAdapter);
				
				//Kolla om resultatet är valid, alltså om username och password matchar en row i databasen
				if($result->isValid())
				{
					$userInfo = new Application_Model_GetUserInfo();
					
					$user = $authAdapter->getResultRowObject();
					
					$userInfo = $userInfo->getUserInfo($user->userid);
					
					$session = new Application_Model_UserSession($user, $userInfo);
					
					//Spara session till zend storage
					$authStorage = $auth->getStorage();
					$authStorage->write($session);
					
					//Redirect till mytweets
					$this->_redirect('tweets/mytweets');
				}
				else
				{
					$this->view->errorMessage = 'Användarnamn eller lösenord är fel';
				}
			}
		}
	
		//"Pusha" formen till view:en
		$this->view->form = $form;
    }

    public function logoutAction()
    {
		//Rensa session
        Zend_Auth::getInstance()->clearIdentity();
		$this->_redirect('/index/index');
    }

    private function getAuthAdapter()
    {
		//authAdapter vet hur den kopplar till databasen tack vare application.ini
		$authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
		
		//Tala om för adaptern vilken tabell den ska titta i
		$authAdapter->setTableName('users')
					->setIdentityColumn('username')
					->setCredentialColumn('password');
		
		return $authAdapter;
    }

	
    public function registerAction()
    {
        // action body
    }
}