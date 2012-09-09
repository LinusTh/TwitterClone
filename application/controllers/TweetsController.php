<?php

class TweetsController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->addHelperPath('ZendX/JQuery/View/Helper', 'ZendX_JQuery_View_Helper');
		//Om man inte är inloggad redirectas man till login
		if(!Zend_Auth::getInstance()->hasIdentity())
		{
			//$this->_redirect('authentication/login');
		}
	}

    public function indexAction()
    {
        // action body
    }

    public function mytweetsAction()
    {
		//Om man inte är inloggad redirectas man till login
		if(!Zend_Auth::getInstance()->hasIdentity())
		{
			$this->_redirect('authentication/login');
		}
		
		//Hämta information om användaren från session
		$userObject = Zend_Auth::getInstance()->getIdentity();
		
        $tweetsList = new Application_Model_ListTweets();
		$tweetsList = $tweetsList->listTweets($userObject->userid, 10);
		
		$this->view->tweetsList = $tweetsList[0];
		
		$this->view->userinfo = $tweetsList[1];
		
		//Skicka alla users i userinfo till this->view
		$db = new Application_Model_DbTable_Userinfo();
		$selectUserinfo = $db->select();
		$rows = $db->fetchAll($selectUserinfo);
		
		$infoArray[] = null;
		foreach($rows as $user)
		{
			$infoArray[$user->userid] = $user;
		}
		$this->view->allUsers = $infoArray;
    }

    public function myflowAction()
    {
		//Om man inte är inloggad redirectas man till login
		if(!Zend_Auth::getInstance()->hasIdentity())
		{
			$this->_redirect('authentication/login');
		}
		
		$userObject = Zend_Auth::getInstance()->getIdentity();
		
        $flow = new Application_Model_ListTweets();
		$flow = $flow->getFlow($userObject->userid);
		
		if($flow == null)
		{
			return;
		}
		
		$this->view->tweetflow = $flow[0];
		
		//Stoppa in userinfo i en array där nycklarna är userid
		$infoArray[] = null;
		foreach($flow[1] as $user)
		{
			$infoArray[$user->userid] = $user;
		}
		$this->view->userinfo = $infoArray;
    }

    public function userAction()
    {
		if(isset($_GET['u']))
		{
			$username = $_GET['u'];
			
			$db = new Application_Model_DbTable_Users();
			$selectUser = $db->select();
			$selectUser->where('username = "'.$username.'"', 'NEW');
			
			$rows = $db->fetchAll($selectUser);
			$userid = $rows[0]->userid;
			
			
			//Bryta ner i en egen metod?
			$tweetsList = new Application_Model_ListTweets();
			$tweetsList = $tweetsList->listTweets($userid, 10);
			
			$this->view->tweetsList = $tweetsList[0];
			$this->view->userinfo = $tweetsList[1];
		}
    }

    public function submittweetAction()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST")
		{
			$message = $_POST['message'];
			$tweetsList = new Application_Model_ListTweets();
			$tweetsList->addTweet($message);
		
		}
	}

    public function myprofileAction()
    {
		//Om man inte är inloggad redirectas man till login
		if(!Zend_Auth::getInstance()->hasIdentity())
		{
			$this->_redirect('authentication/login');
		}
		
		$userObject = Zend_Auth::getInstance()->getIdentity();
        $userinfo = new Application_Model_GetUserInfo();
		
		$this->view->userinfo = $userinfo->getUserInfo($userObject->userid);
		$this->view->email = $userinfo->getEmail($userObject->userid);
    }

    public function writetweetsAction()
    {
		//Om man inte är inloggad redirectas man till login
		if(!Zend_Auth::getInstance()->hasIdentity())
		{
			$this->_redirect('authentication/login');
		}
		
        $this->_helper->layout->disableLayout();
		
		//Skicka alla users i userinfo till this->view
		$db = new Application_Model_DbTable_Userinfo();
		$selectUserinfo = $db->select();
		$rows = $db->fetchAll($selectUserinfo);
		
		$infoArray[] = null;
		foreach($rows as $user)
		{
			$infoArray[$user->userid] = $user;
		}
		$this->view->allUsers = $infoArray;
    }

}













