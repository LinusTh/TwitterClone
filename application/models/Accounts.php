<?php

class Application_Model_Accounts
{

	public function registerUser($info)
	{
		//Stoppa in rätt data i tabellen users
		$db = new Application_Model_DbTable_Users();
		
		$data = array(
			'userid' 	=> '',
			'username'	=> $info['username'],
			'password'	=> $info['password'],
			'email'		=> $info['email']
		);
		
		$db->insert($data);
		
		//Ta fram det nyligen genererade id:t för användaren
		$rows = $db->fetchAll('username = "'.$info['username'].'"');
		$userid = $rows->current()->userid;
		
		//Stoppa in rätt data i tabellen userinfo
		$db = new Application_Model_DbTable_Userinfo();
		
		$data = array(
			'userid' 		=> $userid,
			'username'		=> $info['username'],
			'firstname'		=> $info['firstname'],
			'lastname'		=> $info['lastname'],
			'userimage'		=> $info['userimage'],
			'description'	=> $info['description'],
			'location'		=> $info['location'],
			'website'		=> $info['website']
		);
		
		$db->insert($data);	
	}
	
	public function updateUserInfo($infoArray, $userid)
	{
		$user = null;
		
		if(array_key_exists('email', $infoArray))
		{
			$db = new Application_Model_DbTable_Users();
			$data = array('email' => $infoArray['email']);
			$where = 'userid = '.$userid;
			
			$db->update($data, $where);
			unset($infoArray['email']);
		}
		
		$db = new Application_Model_DbTable_Userinfo();
		$where = 'userid = '.$userid;
		$db->update($infoArray, $where);
		$rows = $db->fetchAll($where);
		$userinfo = $rows[0];
		
		$db = new Application_Model_DbTable_Users();
		$rows = $db->fetchAll($where);
		$user = $rows[0];
		
		
		//Uppdatera "session"
		$userInfo = new Application_Model_GetUserInfo();
		$userInfo = $userInfo->getUserInfo($user->userid);
		$session = new Application_Model_UserSession($user, $userInfo);
		$authStorage = Zend_Auth::getInstance()->getStorage();
		$authStorage->write($session);
	}
	
	//Man kanske ska flytta in email här också?
	public function updateUser($infoArray, $userid)
	{
		$db = new Application_Model_DbTable_Users();
		$where = 'userid = '.$userid;
		$db->update($infoArray, $where);
	}
}

