<?php

class Admin_Model_User_Entity extends Zf_Model_Entity
{

	protected $id;

	protected $name;

	protected $email;

	protected $password;

	protected $challenge;

	protected $level;

	protected $isAdmin;

	protected $alias;

	protected $status;

	protected $lastActivity;

	/**
	 *
	 * @param int $the_i_Id
	 */
	public function setId ($the_i_Id)
	{
		$this->id = (int) $the_i_Id;
		return $this;
	}

	/**
	 *
	 * @return the $id
	 */
	public function getId ()
	{
		return $this->id;
	}

	/**
	 *
	 * @param string $the_sz_Name
	 */
	public function setName ($the_sz_Name)
	{
		$this->name = (string) $the_sz_Name;
		return $this;
	}

	/**
	 *
	 * @return the $name
	 */
	public function getName ()
	{
		return $this->name;
	}

	/**
	 *
	 * @param string $the_sz_Email
	 */
	public function setEmail ($the_sz_Email)
	{
		$this->email = (string) $the_sz_Email;
		return $this;
	}

	/**
	 *
	 * @return the $email
	 */
	public function getEmail ()
	{
		return $this->email;
	}

	/**
	 *
	 * @param string $the_sz_Password
	 */
	public function setPassword ($the_sz_Password)
	{
		$this->password = (string) $the_sz_Password;
		return $this;
	}

	/**
	 *
	 * @return the $password
	 */
	public function getPassword ()
	{
		return $this->password;
	}

	/**
	 *
	 * @param string $the_sz_Challenge
	 */
	public function setChallenge ($the_sz_Challenge)
	{
		$this->challenge = (string) $the_sz_Challenge;
		return $this;
	}

	/**
	 *
	 * @return the $challenge
	 */
	public function getChallenge ()
	{
		return $this->challenge;
	}

	/**
	 *
	 * @param int $the_i_Level
	 */
	public function setLevel ($the_i_Level)
	{
		$this->level = (int) $the_i_Level;
		return $this;
	}

	/**
	 *
	 * @return the $level
	 */
	public function getLevel ()
	{
		return $this->level;
	}

	/**
	 *
	 * @param string $the_sz_Alias
	 */
	public function setAlias ($the_sz_Alias)
	{
		$this->alias = (string) $the_sz_Alias;
		return $this;
	}

	/**
	 *
	 * @return the $alias
	 */
	public function getAlias ()
	{
		return $this->alias;
	}

	/**
	 *
	 * @param int $the_i_IsAdmin
	 */
	public function setIsAdmin ($the_i_IsAdmin)
	{
		$this->isAdmin = (int) $the_i_IsAdmin;
		return $this;
	}

	/**
	 *
	 * @return the $isAdmin
	 */
	public function getIsAdmin ()
	{
		return $this->isAdmin;
	}

	/**
	 *
	 * @param int $the_i_Status
	 */
	public function setStatus ($the_i_Status)
	{
		$this->status = (int) $the_i_Status;
		return $this;
	}

	/**
	 *
	 * @return the $status
	 */
	public function getStatus ()
	{
		return $this->status;
	}

	/**
	 *
	 * @param int $the_i_LastActivity
	 */
	public function setLastActivity ($the_i_LastActivity)
	{
		$this->lastActivity = (int) $the_i_LastActivity;
		return $this;
	}

	/**
	 *
	 * @return the $lastActivity
	 */
	public function getLastActivity ()
	{
		return $this->lastActivity;
	}

	// public function __toArray() {
	// $array = parent::__toArray();

	// $array['level'] = $this->level->getLevel();

	// return $array;
	// }
}
