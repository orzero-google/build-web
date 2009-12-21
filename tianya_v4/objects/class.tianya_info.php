<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `tianya_info` (
	`tianya_infoid` int(11) NOT NULL auto_increment,
	`name` VARCHAR(255) NOT NULL,
	`type` TINYINT NOT NULL,
	`channel_en` VARCHAR(255) NOT NULL,
	`channel_cn` VARCHAR(255) NOT NULL,
	`title` VARCHAR(255) NOT NULL,
	`author_id` INT NOT NULL,
	`author_name` VARCHAR(255) NOT NULL,
	`pid_list` TEXT NOT NULL,
	`time` TIME NOT NULL, PRIMARY KEY  (`tianya_infoid`)) ENGINE=MyISAM;
*/

/**
* <b>tianya_info</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 3.0e / PHP5
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php5&wrapper=pog&objectName=tianya_info&attributeList=array+%28%0A++0+%3D%3E+%27name%27%2C%0A++1+%3D%3E+%27type%27%2C%0A++2+%3D%3E+%27channel_en%27%2C%0A++3+%3D%3E+%27channel_cn%27%2C%0A++4+%3D%3E+%27title%27%2C%0A++5+%3D%3E+%27author_id%27%2C%0A++6+%3D%3E+%27author_name%27%2C%0A++7+%3D%3E+%27pid_list%27%2C%0A++8+%3D%3E+%27time%27%2C%0A%29&typeList=array+%28%0A++0+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++1+%3D%3E+%27TINYINT%27%2C%0A++2+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++3+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++4+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++5+%3D%3E+%27INT%27%2C%0A++6+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++7+%3D%3E+%27TEXT%27%2C%0A++8+%3D%3E+%27TIME%27%2C%0A%29
*/
include_once('class.pog_base.php');
class tianya_info extends POG_Base
{
	public $tianya_infoId = '';

	/**
	 * @var VARCHAR(255)
	 */
	public $name;
	
	/**
	 * @var TINYINT
	 */
	public $type;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $channel_en;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $channel_cn;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $title;
	
	/**
	 * @var INT
	 */
	public $author_id;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $author_name;
	
	/**
	 * @var TEXT
	 */
	public $pid_list;
	
	/**
	 * @var TIME
	 */
	public $time;
	
	public $pog_attribute_type = array(
		"tianya_infoId" => array('db_attributes' => array("NUMERIC", "INT")),
		"name" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"type" => array('db_attributes' => array("NUMERIC", "TINYINT")),
		"channel_en" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"channel_cn" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"title" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"author_id" => array('db_attributes' => array("NUMERIC", "INT")),
		"author_name" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"pid_list" => array('db_attributes' => array("TEXT", "TEXT")),
		"time" => array('db_attributes' => array("NUMERIC", "TIME")),
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
	
	function tianya_info($name='', $type='', $channel_en='', $channel_cn='', $title='', $author_id='', $author_name='', $pid_list='', $time='')
	{
		$this->name = $name;
		$this->type = $type;
		$this->channel_en = $channel_en;
		$this->channel_cn = $channel_cn;
		$this->title = $title;
		$this->author_id = $author_id;
		$this->author_name = $author_name;
		$this->pid_list = $pid_list;
		$this->time = $time;
	}
	
	
	/**
	* Gets object from database
	* @param integer $tianya_infoId 
	* @return object $tianya_info
	*/
	function Get($tianya_infoId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `tianya_info` where `tianya_infoid`='".intval($tianya_infoId)."' LIMIT 1";
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->tianya_infoId = $row['tianya_infoid'];
			$this->name = $this->Unescape($row['name']);
			$this->type = $this->Unescape($row['type']);
			$this->channel_en = $this->Unescape($row['channel_en']);
			$this->channel_cn = $this->Unescape($row['channel_cn']);
			$this->title = $this->Unescape($row['title']);
			$this->author_id = $this->Unescape($row['author_id']);
			$this->author_name = $this->Unescape($row['author_name']);
			$this->pid_list = $this->Unescape($row['pid_list']);
			$this->time = $row['time'];
		}
		return $this;
	}
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $tianya_infoList
	*/
	function GetList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$connection = Database::Connect();
		$sqlLimit = ($limit != '' ? "LIMIT $limit" : '');
		$this->pog_query = "select * from `tianya_info` ";
		$tianya_infoList = Array();
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
			$sortBy = "tianya_infoid";
		}
		$this->pog_query .= " order by ".$sortBy." ".($ascending ? "asc" : "desc")." $sqlLimit";
		$thisObjectName = get_class($this);
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$tianya_info = new $thisObjectName();
			$tianya_info->tianya_infoId = $row['tianya_infoid'];
			$tianya_info->name = $this->Unescape($row['name']);
			$tianya_info->type = $this->Unescape($row['type']);
			$tianya_info->channel_en = $this->Unescape($row['channel_en']);
			$tianya_info->channel_cn = $this->Unescape($row['channel_cn']);
			$tianya_info->title = $this->Unescape($row['title']);
			$tianya_info->author_id = $this->Unescape($row['author_id']);
			$tianya_info->author_name = $this->Unescape($row['author_name']);
			$tianya_info->pid_list = $this->Unescape($row['pid_list']);
			$tianya_info->time = $row['time'];
			$tianya_infoList[] = $tianya_info;
		}
		return $tianya_infoList;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $tianya_infoId
	*/
	function Save()
	{
		$connection = Database::Connect();
		$this->pog_query = "select `tianya_infoid` from `tianya_info` where `tianya_infoid`='".$this->tianya_infoId."' LIMIT 1";
		$rows = Database::Query($this->pog_query, $connection);
		if ($rows > 0)
		{
			$this->pog_query = "update `tianya_info` set 
			`name`='".$this->Escape($this->name)."', 
			`type`='".$this->Escape($this->type)."', 
			`channel_en`='".$this->Escape($this->channel_en)."', 
			`channel_cn`='".$this->Escape($this->channel_cn)."', 
			`title`='".$this->Escape($this->title)."', 
			`author_id`='".$this->Escape($this->author_id)."', 
			`author_name`='".$this->Escape($this->author_name)."', 
			`pid_list`='".$this->Escape($this->pid_list)."', 
			`time`='".$this->time."' where `tianya_infoid`='".$this->tianya_infoId."'";
		}
		else
		{
			$this->pog_query = "insert into `tianya_info` (`name`, `type`, `channel_en`, `channel_cn`, `title`, `author_id`, `author_name`, `pid_list`, `time` ) values (
			'".$this->Escape($this->name)."', 
			'".$this->Escape($this->type)."', 
			'".$this->Escape($this->channel_en)."', 
			'".$this->Escape($this->channel_cn)."', 
			'".$this->Escape($this->title)."', 
			'".$this->Escape($this->author_id)."', 
			'".$this->Escape($this->author_name)."', 
			'".$this->Escape($this->pid_list)."', 
			'".$this->time."' )";
		}
		$insertId = Database::InsertOrUpdate($this->pog_query, $connection);
		if ($this->tianya_infoId == "")
		{
			$this->tianya_infoId = $insertId;
		}
		return $this->tianya_infoId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $tianya_infoId
	*/
	function SaveNew()
	{
		$this->tianya_infoId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$connection = Database::Connect();
		$this->pog_query = "delete from `tianya_info` where `tianya_infoid`='".$this->tianya_infoId."'";
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
			$pog_query = "delete from `tianya_info` where ";
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