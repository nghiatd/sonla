<?php

class Admin_Model_LoginAttempt_Entity extends Zf_Model_Entity
{
	protected $id;
	protected $datetime;
	protected $ip;
	protected $location;
	protected $success;
	protected $username;
	protected $area;

	/**
	 * @param int $the_i_Id
	 */
	public function setId($the_i_Id) {
		$this->id = (int) $the_i_Id;
		return $this;
	}

	/**
	 * @return int $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param int $the_i_DateTime
	 */
	public function setDatetime($the_i_DateTime) {
		$this->datetime = (int) $the_i_DateTime;
		return $this;
	}

	/**
	 * @return int $datetime
	 */
	public function getDatetime() {
		return $this->datetime;
	}

	/**
	 * @param string $the_sz_Ip
	 */
	public function setIp($the_sz_Ip) {
		$this->ip = (string) $the_sz_Ip;
		return $this;
	}

	/**
	 * @return string $ip
	 */
	public function getIp() {
		return $this->ip;
	}

	/**
	 * @param string $the_sz_Location
	 */
	public function setLocation($the_sz_Location) {
		$this->location = (string) $the_sz_Location;
		return $this;
	}

	/**
	 * @return string $location
	 */
	public function getLocation() {
		return $this->location;
	}

	/**
	 * @param int $the_i_Success
	 */
	public function setSuccess($the_i_Success) {
		$this->success = (int) $the_i_Success;
		return $this;
	}

	/**
	 * @return int $success
	 */
	public function getSuccess() {
		return $this->success;
	}

	/**
	 * @param string $the_sz_Username
	 */
	public function setUsername($the_sz_Username) {
		$this->username = (string) $the_sz_Username;
		return $this;
	}

	/**
	 * @return string $username
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * @param string $the_sz_Area
	 */
	public function setArea($the_sz_Area) {
		$this->area = (string) $the_sz_Area;
		return $this;
	}

	/**
	 * @return string $area
	 */
	public function getArea() {
		return $this->area;
	}
}
