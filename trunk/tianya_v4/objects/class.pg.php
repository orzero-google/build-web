<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `pg` (
	`pgid` int(11) NOT NULL auto_increment,
	`name` VARCHAR(255) NOT NULL,
	`url` VARCHAR(255) NOT NULL,
	`dir` VARCHAR(255) NOT NULL,
	`type` TINYINT NOT NULL,
	`form_vars` VARCHAR(255) NOT NULL,
	`fid` INT NOT NULL,
	`tid` INT NOT NULL,
	`time` TIME NOT NULL,
	`page_size` INT NOT NULL,
	`cache_size` INT NOT NULL,
	`state` TINYINT NOT NULL, PRIMARY KEY  (`pgid`)) ENGINE=MyISAM;
*/

/**
* <b>PG</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 3.0e / PHP5.1 MYSQL
* @see http://www.phpobjectgenerator.com/plog/tutorials/45/pdo-mysql
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php5.1&wrapper=pdo&pdoDriver=mysql&objectName=PG&attributeList=array+%28%0A++0+%3D%3E+%27name%27%2C%0A++1+%3D%3E+%27url%27%2C%0A++2+%3D%3E+%27dir%27%2C%0A++3+%3D%3E+%27type%27%2C%0A++4+%3D%3E+%27form_vars%27%2C%0A++5+%3D%3E+%27fid%27%2C%0A++6+%3D%3E+%27tid%27%2C%0A++7+%3D%3E+%27time%27%2C%0A++8+%3D%3E+%27page_size%27%2C%0A++9+%3D%3E+%27cache_size%27%2C%0A++10+%3D%3E+%27state%27%2C%0A%29&typeList=array%2B%2528%250A%2B%2B0%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B1%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B2%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B3%2B%253D%253E%2B%2527TINYINT%2527%252C%250A%2B%2B4%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B5%2B%253D%253E%2B%2527INT%2527%252C%250A%2B%2B6%2B%253D%253E%2B%2527INT%2527%252C%250A%2B%2B7%2B%253D%253E%2B%2527TIME%2527%252C%250A%2B%2B8%2B%253D%253E%2B%2527INT%2527%252C%250A%2B%2B9%2B%253D%253E%2B%2527INT%2527%252C%250A%2B%2B10%2B%253D%253E%2B%2527TINYINT%2527%252C%250A%2529
*/
include_once('class.pog_base.php');
class PG extends POG_Base
{
	public $pgId = '';

	/**
	 * @var VARCHAR(255)
	 */
	public $name;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $url;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $dir;
	
	/**
	 * @var TINYINT
	 */
	public $type;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $form_vars;
	
	/**
	 * @var INT
	 */
	public $fid;
	
	/**
	 * @var INT
	 */
	public $tid;
	
	/**
	 * @var TIME
	 */
	public $time;
	
	/**
	 * @var INT
	 */
	public $page_size;
	
	/**
	 * @var INT
	 */
	public $cache_size;
	
	/**
	 * @var TINYINT
	 */
	public $state;
	
	public $pog_attribute_type = array(
		"pgId" => array('db_attributes' => array("NUMERIC", "INT")),
		"name" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"url" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"dir" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"type" => array('db_attributes' => array("NUMERIC", "TINYINT")),
		"form_vars" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"fid" => array('db_attributes' => array("NUMERIC", "INT")),
		"tid" => array('db_attributes' => array("NUMERIC", "INT")),
		"time" => array('db_attributes' => array("NUMERIC", "TIME")),
		"page_size" => array('db_attributes' => array("NUMERIC", "INT")),
		"cache_size" => array('db_attributes' => array("NUMERIC", "INT")),
		"state" => array('db_attributes' => array("NUMERIC", "TINYINT")),
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
	
	function PG($name='', $url='', $dir='', $type='', $form_vars='', $fid='', $tid='', $time='', $page_size='', $cache_size='', $state='')
	{
		$this->name = $name;
		$this->url = $url;
		$this->dir = $dir;
		$this->type = $type;
		$this->form_vars = $form_vars;
		$this->fid = $fid;
		$this->tid = $tid;
		$this->time = $time;
		$this->page_size = $page_size;
		$this->cache_size = $cache_size;
		$this->state = $state;
	}
	
	
	/**
	* Gets object from database
	* @param integer $pgId 
	* @return object $PG
	*/
	function Get($pgId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `pg` where `pgid`='".intval($pgId)."' LIMIT 1";
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->pgId = $row['pgid'];
			$this->name = $this->Unescape($row['name']);
			$this->url = $this->Unescape($row['url']);
			$this->dir = $this->Unescape($row['dir']);
			$this->type = $this->Unescape($row['type']);
			$this->form_vars = $this->Unescape($row['form_vars']);
			$this->fid = $this->Unescape($row['fid']);
			$this->tid = $this->Unescape($row['tid']);
			$this->time = $row['time'];
			$this->page_size = $this->Unescape($row['page_size']);
			$this->cache_size = $this->Unescape($row['cache_size']);
			$this->state = $this->Unescape($row['state']);
		}
		return $this;
	}
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $pgList
	*/
	function GetList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$connection = Database::Connect();
		$sqlLimit = ($limit != '' ? "LIMIT $limit" : '');
		$this->pog_query = "select * from `pg` ";
		$pgList = Array();
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
			$sortBy = "pgid";
		}
		$this->pog_query .= " order by ".$sortBy." ".($ascending ? "asc" : "desc")." $sqlLimit";
		$thisObjectName = get_class($this);
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$pg = new $thisObjectName();
			$pg->pgId = $row['pgid'];
			$pg->name = $this->Unescape($row['name']);
			$pg->url = $this->Unescape($row['url']);
			$pg->dir = $this->Unescape($row['dir']);
			$pg->type = $this->Unescape($row['type']);
			$pg->form_vars = $this->Unescape($row['form_vars']);
			$pg->fid = $this->Unescape($row['fid']);
			$pg->tid = $this->Unescape($row['tid']);
			$pg->time = $row['time'];
			$pg->page_size = $this->Unescape($row['page_size']);
			$pg->cache_size = $this->Unescape($row['cache_size']);
			$pg->state = $this->Unescape($row['state']);
			$pgList[] = $pg;
		}
		return $pgList;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $pgId
	*/
	function Save()
	{
		$connection = Database::Connect();
		print_r($connection);exit;
		$this->pog_query = "select `pgid` from `pg` where `pgid`='".$this->pgId."' LIMIT 1";
		$rows = Database::Query($this->pog_query, $connection);
		if ($rows > 0)
		{
			$this->pog_query = "update `pg` set 
			`name`='".$this->Escape($this->name)."', 
			`url`='".$this->Escape($this->url)."', 
			`dir`='".$this->Escape($this->dir)."', 
			`type`='".$this->Escape($this->type)."', 
			`form_vars`='".$this->Escape($this->form_vars)."', 
			`fid`='".$this->Escape($this->fid)."', 
			`tid`='".$this->Escape($this->tid)."', 
			`time`='".$this->time."', 
			`page_size`='".$this->Escape($this->page_size)."', 
			`cache_size`='".$this->Escape($this->cache_size)."', 
			`state`='".$this->Escape($this->state)."' where `pgid`='".$this->pgId."'";
		}
		else
		{
			$this->pog_query = "insert into `pg` (`name`, `url`, `dir`, `type`, `form_vars`, `fid`, `tid`, `time`, `page_size`, `cache_size`, `state` ) values (
			'".$this->Escape($this->name)."', 
			'".$this->Escape($this->url)."', 
			'".$this->Escape($this->dir)."', 
			'".$this->Escape($this->type)."', 
			'".$this->Escape($this->form_vars)."', 
			'".$this->Escape($this->fid)."', 
			'".$this->Escape($this->tid)."', 
			'".$this->time."', 
			'".$this->Escape($this->page_size)."', 
			'".$this->Escape($this->cache_size)."', 
			'".$this->Escape($this->state)."' )";
		}
		$insertId = Database::InsertOrUpdate($this->pog_query, $connection);
		if ($this->pgId == "")
		{
			$this->pgId = $insertId;
		}
		return $this->pgId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $pgId
	*/
	function SaveNew()
	{
		$this->pgId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$connection = Database::Connect();
		$this->pog_query = "delete from `pg` where `pgid`='".$this->pgId."'";
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
			$pog_query = "delete from `pg` where ";
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