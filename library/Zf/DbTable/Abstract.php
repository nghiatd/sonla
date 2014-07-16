<?php
/**
 * Abstract class of OSS DbTable class.
 * All other class that manipulate with database must extends from this class.
 * In bootstrap we has registered 3 database connection in Zend_Registry.
 *
 * @author		DungNT
 * @category	Zf_LIBRARY
 * @package		Db
 */
class Zf_DbTable_Abstract extends Zend_Db_Table_Abstract
{
	
	public function __construct() 
	{	
		parent::__construct();
		if( empty($this->_db) ) 
		{
			$a_DbAdapter = Zend_Registry::get('dbAdapters');
			$this->_db = $a_DbAdapter;
		}	
	}

	/**
     * Initializes metadata.
     *
     * If metadata cannot be loaded from cache, adapter's describeTable() method is called to discover metadata
     * information. Returns true if and only if the metadata are loaded from cache.
	 *
	 * jpl: override method to catch non-critical Exception, http://framework.zend.com/issues/browse/ZF-6161
	 * remove this fix if Zend Framework >= 1.10.2
     *
     * @return boolean
     * @throws Zend_Db_Table_Exception
     */
	protected function _setupMetadata()
    {
		try
		{
			parent::_setupMetadata();
		}
		catch (Zend_Db_Table_Exception $a_sz_Exception)
		{
			if($a_sz_Exception->getMessage()=='Failed saving metadata to metadataCache')
			{
				trigger_error('Failed saving metadata to metadataCache', E_USER_NOTICE);
			}
		}
	}
	
	/**
	 * Execuse query
	 * 
	 * @param $the_sz_Query
	 * 
	 * @return void
	 */
	public function v_fExecuseQuery( $the_sz_Query )
	{
		return $this->_db->query( $the_sz_Query );
	}

	/**
	 * Generates the condition string that will be put in the WHERE part
	 * @param array $conditions the conditions that will be put in the WHERE part.
	 * @return string the condition string to put in the WHERE part
	 */
	protected function processConditions($conditions)
	{
		if (!is_array($conditions)) return $conditions;
		if (!isset($conditions[0])) return '';		
		
		$operator = strtoupper(trim((string) $conditions[0]));
		
		if (in_array($operator, array('OR', 'AND')))
		{
			$parts = array();
			$n = count($conditions);
			for($i = 1; $i < $n; ++$i)
			{
				$condition = $this->processConditions($conditions[$i]);
				if ($condition !== '') $parts[] = '(' . $condition . ')';
			}
			
			return ($parts === array()) ? '1=1' : implode(' '.$operator.' ', $parts);
		}
		
		if (!isset($conditions[1], $conditions[2])) return '';

		$column = $conditions[1];		
		if (strpos($column, '(') === false) $column = $this->_db->quoteInto($column, null);

		$values = $conditions[2];
		if (!is_array($values)) $values = array($values);
		if (in_array($operator, array('IN', 'NOT IN')))
		{
			if ($values === array()) return ($operator === 'IN') ? '0=1' : '';		
			return $column . ' ' . $operator . ' ('. $this->_db->quote($values) . ')';
		}

		if (in_array($operator, array('LIKE', 'NOT LIKE', 'OR LIKE', 'OR NOT LIKE')))
		{
			if ($values === array()) return (in_array($operator, array('LIKE', 'OR LIKE'))) ? '0=1' : '';
			if (in_array($operator, array('LIKE', 'NOT LIKE')))
			{
				$andor = ' AND ';
			} else
			{
				$andor = ' OR ';
				$operator = ($operator === 'OR LIKE') ? ' LIKE ' : ' NOT LIKE ';
			}
			
			$expressions = array();			
			foreach($values as $value)
			{
				$expressions[] = $column . ' ' . $operator . ' ' . $this->_db->quote($value);
			}
			
			return implode($andor, $expressions);
		}

		throw new Nid_Oss_Exception('Unknown operator "' . $operator . '"');
	}
}