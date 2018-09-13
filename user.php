<?php

class User {

	private $user_id;
	private $username;
	private $pass;
	private $description;
	private $userstr;
	public $loggedin;
	private $db;

	public function __construct()
	{
		$this->userstr = ' (Guest)';
		if (isset($_SESSION['user']))
		{
			$this->username = $_SESSION['user'];
			$this->loggedin = TRUE;
			$this->userstr = " ($this->username)";
		}
		else
		{
			$this->loggedin = FALSE;
		}

	}

	public function getUsername()
	{
		return $this->username;
	}

	public function getUserstr()
	{
		return $this->userstr;
	}

	public function getPass()
	{
		return $this->pass;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public static function totalMembers() {
		global $con;
		$result = $con->query('SELECT COUNT(user_id) FROM members');
		$members = $result->fetch(PDO::FETCH_NUM)[0];
		return $members;
	}
}
