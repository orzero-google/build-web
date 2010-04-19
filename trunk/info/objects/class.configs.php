<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `configs` (
	`configsid` int(11) NOT NULL auto_increment,
	`type` INT NOT NULL,
	`key` VARCHAR(255) NOT NULL,
	`value` TEXT NOT NULL, PRIMARY KEY  (`configsid`)) ENGINE=MyISAM;
*/

/**
* <b>configs</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 3.0e / PHP5.1 MYSQL
* @see http://www.phpobjectgenerator.com/plog/tutorials/45/pdo-mysql
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php5.1&wrapper=pdo&pdoDriver=mysql&objectName=configs&attributeList=array+%28%0A++0+%3D%3E+%27type%27%2C%0A++1+%3D%3E+%27key%27%2C%0A++2+%3D%3E+%27value%27%2C%0A%29&typeList=array%2B%2528%250A%2B%2B0%2B%253D%253E%2B%2527INT%2527%252C%250A%2B%2B1%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B2%2B%253D%253E%2B%2527TEXT%2527%252C%250A%2529
*/
include_once('class.pog_base.php');
class configs extends POG_Base
{
	public $configsId = '';

	/**
	 * @var INT
	 */
	public $type;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $key;
	
	/**
	 * @var TEXT
	 */
	public $value;
	
	public $pog_attribute_type = array(
		"configsId" => array('db_attributes' => array("NUMERIC", "INT")),
		"type" => array('db_attributes' => array("NUMERIC", "INT")),
		"key" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"value" => array('db_attributes' => array("TEXT", "TEXT")),
		);
	public $pog_query;
	
	
	/**
	* Getter for some private attributes
	* @return mixed $attribute
	*/
	public function __get($attribute)
	{
		if (isset($this->{"_".$attribute}))
		{
			return $this->{"_".$attribute};
		}
		else
		{
			return false;
		}
	}
	
	function configs($type='', $key='', $value='')
	{
		$this->type = $type;
		$this->key = $key;
		$this->value = $value;
	}
	
	
	/**
	* Gets object from database
	* @param integer $configsId 
	* @return object $configs
	*/
	function Get($configsId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `configs` where `configsid`='".intval($configsId)."' LIMIT 1";
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->configsId = $row['configsid'];
			$this->type = $this->Unescape($row['type']);
			$this->key = $this->Unescape($row['key']);
			$this->value = $this->Unescape($row['value']);
		}
		return $this;
	}
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $configsList
	*/
	function GetList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$connection = Database::Connect();
		$sqlLimit = ($limit != '' ? "LIMIT $limit" : '');
		$this->pog_query = "select * from `configs` ";
		$configsList = Array();
		if (sizeof($fcv_array) > 0)
		{
			$this->pog_query .= " where ";
			for ($i=0, $c=sizeof($fcv_array); $i<$c; $i++)
			{
				if (sizeof($fcv_array[$i]) == 1)
				{
					$this->pog_query .= " ".$fcv_array[$i][0]." ";
					continue;
				}
				else
				{
					if ($i > 0 && sizeof($fcv_array[$i-1]) != 1)
					{
						$this->pog_query .= " AND ";
					}
					if (isset($this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes']) && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'NUMERIC' && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'SET')
					{
						if ($GLOBALS['configuration']['db_encoding'] == 1)
						{
							$value = POG_Base::IsColumn($fcv_array[$i][2]) ? "BASE64_DECODE(".$fcv_array[$i][2].")" : "'".$fcv_array[$i][2]."'";
							$this->pog_query .= "BASE64_DECODE(`".$fcv_array[$i][0]."`) ".$fcv_array[$i][1]." ".$value;
						}
						else
						{
							$value =  POG_Base::IsColumn($fcv_array[$i][2]) ? $fcv_array[$i][2] : "'".$this->Escape($fcv_array[$i][2])."'";
							$this->pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." ".$value;
						}
					}
					else
					{
						$value = POG_Base::IsColumn($fcv_array[$i][2]) ? $fcv_array[$i][2] : "'".$fcv_array[$i][2]."'";
						$this->pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." ".$value;
					}
				}
			}
		}
		if ($sortBy != '')
		{
			if (isset($this->pog_attribute_type[$sortBy]['db_attributes']) && $this->pog_attribute_type[$sortBy]['db_attributes'][0] != 'NUMERIC' && $this->pog_attribute_type[$sortBy]['db_attributes'][0] != 'SET')
			{
				if ($GLOBALS['configuration']['db_encoding'] == 1)
				{
					$sortBy = "BASE64_DECODE($sortBy) ";
				}
				else
				{
					$sortBy = "$sortBy ";
				}
			}
			else
			{
				$sortBy = "$sortBy ";
			}
		}
		else
		{
			$sortBy = "configsid";
		}
		$this->pog_query .= " order by ".$sortBy." ".($ascending ? "asc" : "desc")." $sqlLimit";
		$thisObjectName = get_class($this);
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$configs = new $thisObjectName();
			$configs->configsId = $row['configsid'];
			$configs->type = $this->Unescape($row['type']);
			$configs->key = $this->Unescape($row['key']);
			$configs->value = $this->Unescape($row['value']);
			$configsList[] = $configs;
		}
		return $configsList;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $configsId
	*/
	function Save()
	{
		$connection = Database::Connect();
		$this->pog_query = "select `configsid` from `configs` where `configsid`='".$this->configsId."' LIMIT 1";
		$rows = Database::Query($this->pog_query, $connection);
		if ($rows > 0)
		{
			$this->pog_query = "update `configs` set 
			`type`='".$this->Escape($this->type)."', 
			`key`='".$this->Escape($this->key)."', 
			`value`='".$this->Escape($this->value)."' where `configsid`='".$this->configsId."'";
		}
		else
		{
			$this->pog_query = "insert into `configs` (`type`, `key`, `value` ) values (
			'".$this->Escape($this->type)."', 
			'".$this->Escape($this->key)."', 
			'".$this->Escape($this->value)."' )";
		}
		$insertId = Database::InsertOrUpdate($this->pog_query, $connection);
		if ($this->configsId == "")
		{
			$this->configsId = $insertId;
		}
		return $this->configsId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $configsId
	*/
	function SaveNew()
	{
		$this->configsId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$connection = Database::Connect();
		$this->pog_query = "delete from `configs` where `configsid`='".$this->configsId."'";
		return Database::NonQuery($this->pog_query, $connection);
	}
	
	
	/**
	* Deletes a list of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param bool $deep 
	* @return 
	*/
	function DeleteList($fcv_array)
	{
		if (sizeof($fcv_array) > 0)
		{
			$connection = Database::Connect();
			$pog_query = "delete from `configs` where ";
			for ($i=0, $c=sizeof($fcv_array); $i<$c; $i++)
			{
				if (sizeof($fcv_array[$i]) == 1)
				{
					$pog_query .= " ".$fcv_array[$i][0]." ";
					continue;
				}
				else
				{
					if ($i > 0 && sizeof($fcv_array[$i-1]) !== 1)
					{
						$pog_query .= " AND ";
					}
					if (isset($this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes']) && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'NUMERIC' && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'SET')
					{
						$pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." '".$this->Escape($fcv_array[$i][2])."'";
					}
					else
					{
						$pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." '".$fcv_array[$i][2]."'";
					}
				}
			}
			return Database::NonQuery($pog_query, $connection);
		}
	}
}
?>