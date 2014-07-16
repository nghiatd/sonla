<?php

class Admin_Model_Content_Entity extends Zf_Model_Entity
{
	protected $id;
	protected $code;
	protected $name_en;
	protected $name_vi;
	protected $description_en;
	protected $description_vi;
	protected $parent_id;
	protected $sort;
	protected $status;
	protected $lastActivity;

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
	 * @param string $the_sz_Code
	 */
	public function setCode($the_sz_Code) {
		$this->code = (string) $the_sz_Code;
		return $this;
	}

	/**
	 * @return string $code
	 */
	public function getCode() {
		return $this->code;
	}

	/**
	 * @param string $the_sz_NameEn
	 */
	public function setName_en($the_sz_NameEn) {
		$this->name_en = (string) $the_sz_NameEn;
		return $this;
	}

	/**
	 * @return string $name_en
	 */
	public function getName_en() {
		return $this->name_en;
	}

	/**
	 * @param string $the_sz_NameVi
	 */
	public function setName_vi($the_sz_NameVi) {
		$this->name_vi = (string) $the_sz_NameVi;
		return $this;
	}

	/**
	 * @return string $name_vi
	 */
	public function getName_vi() {
		return $this->name_vi;
	}

	/**
	 * @param string $the_sz_DescriptionEn
	 */
	public function setDescription_en($the_sz_DescriptionEn) {
		$this->description_en = (string) $the_sz_DescriptionEn;
		return $this;
	}

	/**
	 * @return string $description_en
	 */
	public function getDescription_en() {
		return $this->description_en;
	}

	/**
	 * @param string $the_sz_DescriptionVi
	 */
	public function setDescription_vi($the_sz_DescriptionVi) {
		$this->description_vi = (string) $the_sz_DescriptionVi;
		return $this;
	}

	/**
	 * @return string $description_vi
	 */
	public function getDescription_vi() {
		return $this->description_vi;
	}

	/**
	 * @param int $the_i_ParentId
	 */
	public function setParent_id($the_i_ParentId) {
		$this->parent_id = (int) $the_i_ParentId;
		return $this;
	}

	/**
	 * @return int $parent_id
	 */
	public function getParent_id() {
		return $this->parent_id;
	}

	/**
	 * @param int $the_i_Sort
	 */
	public function setSort($the_i_Sort) {
		$this->sort = (int) $the_i_Sort;
		return $this;
	}

	/**
	 * @return int $sort
	 */
	public function getSort() {
		return $this->sort;
	}

	/**
	 * @param int $the_i_Status
	 */
	public function setStatus($the_i_Status) {
		$this->status = (int) $the_i_Status;
		return $this;
	}

	/**
	 * @return int $status
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @param int $the_i_LastActivity
	 */
	public function setLastActivity($the_i_LastActivity) {
		$this->lastActivity = (int) $the_i_LastActivity;
		return $this;
	}

	/**
	 * @return int $lastActivity
	 */
	public function getLastActivity() {
		return $this->lastActivity;
	}
}