<?php

class Application_Model_ListTweets
{

	public function listTweets($userid, $tweetsShowing)
	{
		//Välj alla tweets av en viss användare
		$db = new Application_Model_DbTable_Tweets();
		$selectTweets = $db->select();
		$selectTweets->where('userid = '.$userid, 'NEW')
					 ->order('timestamp DESC');
		
		$tweetRows = $db->fetchAll($selectTweets);
		
		//Välj userinfo för användaren
		$db = new Application_Model_DbTable_Userinfo();
		$selectUserinfo = $db->select();
		$selectUserinfo->where('userid = '.$userid, 'NEW');
		$selectUserinfo->limit($tweetsShowing);
		
		$userInfoRows = $db->fetchAll($selectUserinfo);
		
		if($tweetRows != null && $userInfoRows != null)
		{
			return array($tweetRows, $userInfoRows[0]);
		}
		else
		{
			echo 'Det fanns inga matchande tweets';
		}
	}
	
	public function addTweet($message, $replyid)
	{
		$db = new Application_Model_DbTable_Tweets();
		$userObject = Zend_Auth::getInstance()->getIdentity();
		
		$time = time();
		//$time = date("y/m/d H:i:s", time()) ;
		$message = mysql_real_escape_string($message); 
		
		$data = array(
			'tweetid' 	=> '',
			'userid' 	=> $userObject->userid,
			'message'	=> $message,
			'timestamp'	=> $time,
			'replyTo'	=> $replyid
		);
		
		$db->insert($data);
	}
	
	
	public function getFlow($userid)
	{
		$db = new Application_Model_DbTable_Followers();
		$selectFollowers = $db->select();
		
		//Plocka fram alla rows i followers som gäller för den inloggade användaren
		$selectFollowers->where('userid = '.$userid, 'NEW');
		$rows = $db->fetchAll($selectFollowers);
		
		//Om den aktiva användaren inte följer någon
		if(count($rows) == 0)
		{
			return null;
		}
		
		$followedUsers = array();
		//Plocka fram id för varje användare man följer
		foreach($rows as $row)
		{
			$followedUsers[] = $row->following;
		}
		
		//Skapa en sql-sträng baserat på användarna man följer
		$sqlString = '';
		$followCount = count($followedUsers);
		$counter = 0;
		
		foreach($followedUsers as $user)
		{
			$counter++;
			if($counter < $followCount)
			{
				$sqlString .= 'userid = '.$user.' OR ';
			}
			else
			{
				$sqlString .= 'userid = '.$user;
			}
		}
		$endString = 'NEW';
		//echo $sqlString;
		
		//Ta fram alla tweets som användarna man följer har gjort
		$db = new Application_Model_DbTable_Tweets();
		$selectTweets = $db->select();
		$selectTweets->where($sqlString, $endString)
					 ->order('timestamp DESC');
		
		$tweetRows = $db->fetchAll($selectTweets);
		
		$userInfoRows = $this->getUserInfo($sqlString, $endString);
		
		if($rows != null)
		{
			return array($tweetRows, $userInfoRows);
		}
		else
		{
			return null;
			echo 'Det fanns inga matchande tweets';
		}
	}
	
	public function getTweetById($tweetid)
	{
		
		$db = new Application_Model_DbTable_Tweets();
		$selectTweets = $db->select();
		$selectTweets->where('tweetid = '.$tweetid, 'NEW');
		//echo $selectTweets;
		$tweetRows = $db->fetchAll($selectTweets);
		
		$tweet = $tweetRows[0];
		
		return $tweet;
	}
	
	public function getReplies($tweetid)
	{
		$db = new Application_Model_DbTable_Tweets();
		$selectTweets = $db->select();
		$selectTweets->where('replyto = '.$tweetid, 'NEW');
		$selectTweets->limit(5);
		
		$tweetRows = $db->fetchAll($selectTweets);
		
		return $tweetRows;
	}
	
	public function timeSince($timestamp)
	{
		$timeSinceTweet = time() - $timestamp;
		if($timeSinceTweet < 60)
		{
			echo $timeSinceTweet.' sekund';
			if($timeSinceTweet > 1)
				echo 'er';
			echo ' sedan';
		}
		else if($timeSinceTweet < 3600)
		{
			echo floor($timeSinceTweet / 60).' minut';
			if($timeSinceTweet > 120)
				echo 'er';
			echo ' sedan';
		}
		else if($timeSinceTweet < 86400)
		{
			echo floor($timeSinceTweet / 3600).' timm';
			if($timeSinceTweet > 7200)
				echo 'ar';
			echo 'e sedan';
		}
		else
		{
			echo date('Y-m-d H:i:s', $timestamp);
		}
	}
	
	
	private function getUserInfo($sqlString, $endString)
	{
		//Den här metoden skickar bara tillbaka userinfo för alla användare i $sqlString
		$db = new Application_Model_DbTable_Userinfo();
		$selectUsers = $db->select();
		$selectUsers->where($sqlString, $endString);
		
		return $db->fetchAll($selectUsers);
	}

}

