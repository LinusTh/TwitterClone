<?php

class Application_Model_UserSession
{
	public $userid;
	public $username;
	public $email;
	public $firstname;
	public $lastname;
	public $description;
	public $location;
	public $userimage;
	public $website;
	
	public function __construct($userRow, $infoRow)
	{
		$this->userid = $userRow->userid;
		$this->username = $userRow->username;
		$this->email = $userRow->email;
		
		$this->firstname = $infoRow->firstname;
		$this->lastname = $infoRow->lastname;
		$this->description = $infoRow->description;
		$this->location = $infoRow->location;
		$this->userimage = $infoRow->userimage;
		$this->website = $infoRow->website;
	}

}

