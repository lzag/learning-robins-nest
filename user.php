<?php

class User {

	private $user_id;
	private $user;
	private $pass;
	private $description;

	public function __construct()
	{

	}

	public function getUser()
	{
		return $this->user;
	}

	public function getPass()
	{
		return $this->pass;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function getImageURL()
	{

	}


}
