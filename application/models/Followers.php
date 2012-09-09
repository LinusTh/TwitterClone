<?php

class Application_Model_Followers
{

	public function getFollowedUsers($userid)
	{
		
	}
	
	public function followUser($userid, $userToFollow)
	{
		$db = new Application_Model_DbTable_Followers();
		
		$data = array(
			'userid' 	=> $userid,
			'following' 	=> $userToFollow
		);
		
		$db->insert($data);
	}
	
	
	public function unfollowUser($userid, $userToUnfollow)
	{
		$db = new Application_Model_DbTable_Followers();
		
		$data = array(
			'userid' 	=> $userid,
			'following' 	=> $userToFollow
		);
		
		$db->delete($data);
	}
	
	public function isFollowing($userid, $followedUser)
	{
		$db = new Application_Model_DbTable_Followers();
		$selectFollows = $db->select();
		$selectFollows->where('userid = '.$userid.' AND following = '.$followedUser, 'NEW');
		
		$followRows = $db->fetchAll($selectFollows);
		
		if(count($followRows) != 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

