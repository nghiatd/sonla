<?php

interface Zf_Model_RepositoryInterface
{
	/**
	 * Set the DataMapper to be used in transactions.
	 * 
	 * @param Zf_Model_Interface $data
	 */
	public function setData($data);
	
	/**
	 * Get the DataMapper to be used in transactions.
	 * 
	 * @return Zf_Model_Interface
	 */
	public function getData();
	
	/**
	 * Set the Mapper to be used in data conversion.
	 * 
	 * @param Zf_Model_DataMapper $mapper
	 */
	public function setMapper($mapper);
	
	/**
	 * Get the Mapper to be used in data conversion.
	 * 
	 * @return Zf_Model_DataMapper
	 */
	public function getMapper();
}