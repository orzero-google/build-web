<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `tianya_content` (
	`tianya_contentid` int(11) NOT NULL auto_increment,
	`info_id` INT NOT NULL,
	`pg_id` INT NOT NULL,
	`page_num` MEDIUMINT NOT NULL,
	`url` VARCHAR(255) NOT NULL,
	`dir` VARCHAR(255) NOT NULL, PRIMARY KEY  (`tianya_contentid`)) ENGINE=MyISAM;
*/

/**
* <b>tianya_content</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 3.0e / PHP5
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php5&wrapper=pog&objectName=tianya_content&attributeList=array+%28%0A++0+%3D%3E+%27info_id%27%2C%0A++1+%3D%3E+%27pg_id%27%2C%0A++2+%3D%3E+%27page_num%27%2C%0A++3+%3D%3E+%27url%27%2C%0A++4+%3D%3E+%27dir%27%2C%0A%29&typeList=array+%28%0A++0+%3D%3E+%27INT%27%2C%0A++1+%3D%3E+%27INT%27%2C%0A++2+%3D%3E+%27MEDIUMINT%27%2C%0A++3+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++4+%3D%3E+%27VARCHAR%28255%29%27%2C%0A%29
*/
include_once('class.pog_base.php');
class tianya_content extends POG_Base
{
	public $tianya_contentId = '';

	/**
	 * @var INT
	 */
	public $info_id;
	
	/**
	 * @var INT
	 */
	public $pg_id;
	
	/**
	 * @var MEDIUMINT
	 */
	public $page_num;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $url;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $dir;
	
	public $pog_attribute_type = array(
		"tianya_contentId" => array('db_attributes' => array("NUMERIC", "INT")),
		"info_id" => array('db_attributes' => array("NUMERIC", "INT")),
		"pg_id" => array('db_attributes' => array("NUMERIC", "INT")),
		"page_num" => array('db_attributes' => array("NUMERIC", "MEDIUMINT")),
		"url" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"dir" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
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
	
	function tianya_content($info_id='', $pg_id='', $page_num='', $url='', $dir='')
	{
		$this->info_id = $info_id;
		$this->pg_id = $pg_id;
		$this->page_num = $page_num;
		$this->url = $url;
		$this->dir = $dir;
	}
	
	
	/**
	* Gets object from database
	* @param integer $tianya_contentId 
	* @return object $tianya_content
	*/
	function Get($tianya_contentId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `tianya_content` where `tianya_contentid`='".intval($tianya_contentId)."' LIMIT 1";
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->tianya_contentId = $row['tianya_contentid'];
			$this->info_id = $this->Unescape($row['info_id']);
			$this->pg_id = $this->Unescape($row['pg_id']);
			$this->page_num = $this->Unescape($row['page_num']);
			$this->url = $this->Unescape($row['url']);
			$this->dir = $this->Unescape($row['dir']);
		}
		return $this;
	}
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $tianya_contentList
	*/
	function GetList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$connection = Database::Connect();
		$sqlLimit = ($limit != '' ? "LIMIT $limit" : '');
		$this->pog_query = "select * from `tianya_content` ";
		$tianya_contentList = Array();
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
			$sortBy = "tianya_contentid";
		}
		$this->pog_query .= " order by ".$sortBy." ".($ascending ? "asc" : "desc")." $sqlLimit";
		$thisObjectName = get_class($this);
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$tianya_content = new $thisObjectName();
			$tianya_content->tianya_contentId = $row['tianya_contentid'];
			$tianya_content->info_id = $this->Unescape($row['info_id']);
			$tianya_content->pg_id = $this->Unescape($row['pg_id']);
			$tianya_content->page_num = $this->Unescape($row['page_num']);
			$tianya_content->url = $this->Unescape($row['url']);
			$tianya_content->dir = $this->Unescape($row['dir']);
			$tianya_contentList[] = $tianya_content;
		}
		return $tianya_contentList;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $tianya_contentId
	*/
	function Save()
	{
		$connection = Database::Connect();
		$this->pog_query = "select `tianya_contentid` from `tianya_content` where `tianya_contentid`='".$this->tianya_contentId."' LIMIT 1";
		$rows = Database::Query($this->pog_query, $connection);
		if ($rows > 0)
		{
			$this->pog_query = "update `tianya_content` set 
			`info_id`='".$this->Escape($this->info_id)."', 
			`pg_id`='".$this->Escape($this->pg_id)."', 
			`page_num`='".$this->Escape($this->page_num)."', 
			`url`='".$this->Escape($this->url)."', 
			`dir`='".$this->Escape($this->dir)."' where `tianya_contentid`='".$this->tianya_contentId."'";
		}
		else
		{
			$this->pog_query = "insert into `tianya_content` (`info_id`, `pg_id`, `page_num`, `url`, `dir` ) values (
			'".$this->Escape($this->info_id)."', 
			'".$this->Escape($this->pg_id)."', 
			'".$this->Escape($this->page_num)."', 
			'".$this->Escape($this->url)."', 
			'".$this->Escape($this->dir)."' )";
		}
		$insertId = Database::InsertOrUpdate($this->pog_query, $connection);
		if ($this->tianya_contentId == "")
		{
			$this->tianya_contentId = $insertId;
		}
		return $this->tianya_contentId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $tianya_contentId
	*/
	function SaveNew()
	{
		$this->tianya_contentId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$connection = Database::Connect();
		$this->pog_query = "delete from `tianya_content` where `tianya_contentid`='".$this->tianya_contentId."'";
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
			$pog_query = "delete from `tianya_content` where ";
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