<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `permissions` (
	`permissionsid` int(11) NOT NULL auto_increment,
	`status` TINYINT NOT NULL,
	`type` TINYINT NOT NULL,
	`value` TEXT NOT NULL, PRIMARY KEY  (`permissionsid`)) ENGINE=MyISAM;
*/

/**
* <b>permissions</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 3.0e / PHP5.1 MYSQL
* @see http://www.phpobjectgenerator.com/plog/tutorials/45/pdo-mysql
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php5.1&wrapper=pdo&pdoDriver=mysql&objectName=permissions&attributeList=array+%28%0A++0+%3D%3E+%27status%27%2C%0A++1+%3D%3E+%27type%27%2C%0A++2+%3D%3E+%27value%27%2C%0A%29&typeList=array%2B%2528%250A%2B%2B0%2B%253D%253E%2B%2527TINYINT%2527%252C%250A%2B%2B1%2B%253D%253E%2B%2527TINYINT%2527%252C%250A%2B%2B2%2B%253D%253E%2B%2527TEXT%2527%252C%250A%2529
*/
include_once('class.pog_base.php');
class permissions extends POG_Base
{
	public $permissionsId = '';

	/**
	 * @var TINYINT
	 */
	public $status;
	
	/**
	 * @var TINYINT
	 */
	public $type;
	
	/**
	 * @var TEXT
	 */
	public $value;
	
	public $pog_attribute_type = array(
		"permissionsId" => array('db_attributes' => array("NUMERIC", "INT")),
		"status" => array('db_attributes' => array("NUMERIC", "TINYINT")),
		"type" => array('db_attributes' => array("NUMERIC", "TINYINT")),
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
	
	function permissions($status='', $type='', $value='')
	{
		$this->status = $status;
		$this->type = $type;
		$this->value = $value;
	}
	
	
	/**
	* Gets object from database
	* @param integer $permissionsId 
	* @return object $permissions
	*/
	function Get($permissionsId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `permissions` where `permissionsid`='".intval($permissionsId)."' LIMIT 1";
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->permissionsId = $row['permissionsid'];
			$this->status = $this->Unescape($row['status']);
			$this->type = $this->Unescape($row['type']);
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
	* @return array $permissionsList
	*/
	function GetList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$connection = Database::Connect();
		$sqlLimit = ($limit != '' ? "LIMIT $limit" : '');
		$this->pog_query = "select * from `permissions` ";
		$permissionsList = Array();
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
			$sortBy = "permissionsid";
		}
		$this->pog_query .= " order by ".$sortBy." ".($ascending ? "asc" : "desc")." $sqlLimit";
		$thisObjectName = get_class($this);
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$permissions = new $thisObjectName();
			$permissions->permissionsId = $row['permissionsid'];
			$permissions->status = $this->Unescape($row['status']);
			$permissions->type = $this->Unescape($row['type']);
			$permissions->value = $this->Unescape($row['value']);
			$permissionsList[] = $permissions;
		}
		return $permissionsList;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $permissionsId
	*/
	function Save()
	{
		$connection = Database::Connect();
		$this->pog_query = "select `permissionsid` from `permissions` where `permissionsid`='".$this->permissionsId."' LIMIT 1";
		$rows = Database::Query($this->pog_query, $connection);
		if ($rows > 0)
		{
			$this->pog_query = "update `permissions` set 
			`status`='".$this->Escape($this->status)."', 
			`type`='".$this->Escape($this->type)."', 
			`value`='".$this->Escape($this->value)."' where `permissionsid`='".$this->permissionsId."'";
		}
		else
		{
			$this->pog_query = "insert into `permissions` (`status`, `type`, `value` ) values (
			'".$this->Escape($this->status)."', 
			'".$this->Escape($this->type)."', 
			'".$this->Escape($this->value)."' )";
		}
		$insertId = Database::InsertOrUpdate($this->pog_query, $connection);
		if ($this->permissionsId == "")
		{
			$this->permissionsId = $insertId;
		}
		return $this->permissionsId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $permissionsId
	*/
	function SaveNew()
	{
		$this->permissionsId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$connection = Database::Connect();
		$this->pog_query = "delete from `permissions` where `permissionsid`='".$this->permissionsId."'";
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
			$pog_query = "delete from `permissions` where ";
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