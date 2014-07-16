<?php

class Admin_Model_UserLevel_Entity extends Zf_Model_Entity
{
	protected $level;
	protected $alias;
	protected $isAdmin;

	/**
	 * @param int $the_i_Level
	 */
	public function setLevel($the_i_Level) {
		$this->level = (int) $the_i_Level;
		return $this;
	}

	/**
	 * @return the $level
	 */
	public function getLevel() {
		return $this->level;
	}

	/**
	 * @param string $the_sz_Alias
	 */
	public function setAlias($the_sz_Alias) {
		$this->alias = (string) $the_sz_Alias;
		return $this;
	}

	/**
	 * @return the $alias
	 */
	public function getAlias() {
		return $this->alias;
	}

	/**
	 * @param int $the_i_IsAdmin
	 */
	public function setIsAdmin($the_i_IsAdmin) {
		$this->isAdmin = (int) $the_i_IsAdmin;
		return $this;
	}

	/**
	 * @return the $isAdmin
	 */
	public function getIsAdmin() {
		return $this->isAdmin;
	}

	public function __toString() {
		return ucfirst(strtolower($this->alias));
	}

}
