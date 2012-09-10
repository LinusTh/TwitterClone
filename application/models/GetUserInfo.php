<!-- Author: Linus Thorelli -->

<?php

class Application_Model_GetUserInfo
{

	public function getUserInfo($userid)
	{
		$db = new Application_Model_DbTable_UserInfo();
		$rows = $db->fetchAll('userid = '.$userid);
		$userinfo = $rows->current();
		
		if($userinfo != null)
		{
			return $userinfo;
		}
		else
		{
			return null;
		}
	}
	
	public function checkIfExists($username)
	{
		$db = new Application_Model_DbTable_Users();
		$selectUsers = $db->select();
		$selectUsers->where('username = "'.$username.'"', 'NEW');
		
		$rows = $db->fetchAll($selectUsers);
		$user = $rows->current();
		
		if($user != null)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function getEmail($userid)
	{
		$db = new Application_Model_DbTable_Users();
		$rows = $db->fetchAll('userid = '.$userid);
		return $rows->current()->email;
	}
	
	public function getPassword($userid)
	{
		$db = new Application_Model_DbTable_Users();
		$rows = $db->fetchAll('userid = '.$userid);
		return $rows->current()->password;
	}
}

