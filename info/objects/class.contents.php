<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `contents` (
	`contentsid` int(11) NOT NULL auto_increment,
	`title` VARCHAR(255) NOT NULL,
	`desc` VARCHAR(255) NOT NULL,
	`nickname` VARCHAR(255) NOT NULL,
	`user_id` INT NOT NULL,
	`cate_id` INT NOT NULL,
	`area_id` INT NOT NULL,
	`keys_id` BIGINT NOT NULL,
	`conf_id` INT NOT NULL,
	`content` VARCHAR(255) NOT NULL,
	`mode_id` TINYINT NOT NULL,
	`perm_id` TINYINT NOT NULL,
	`ref_id` BIGINT NOT NULL,
	`order_id` INT NOT NULL,
	`url` VARCHAR(255) NOT NULL,
	`time` TIMESTAMP NOT NULL, PRIMARY KEY  (`contentsid`)) ENGINE=MyISAM;
*/

/**
* <b>contents</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 3.0e / PHP5.1 MYSQL
* @see http://www.phpobjectgenerator.com/plog/tutorials/45/pdo-mysql
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php5.1&wrapper=pdo&pdoDriver=mysql&objectName=contents&attributeList=array+%28%0A++0+%3D%3E+%27title%27%2C%0A++1+%3D%3E+%27desc%27%2C%0A++2+%3D%3E+%27nickname%27%2C%0A++3+%3D%3E+%27user_id%27%2C%0A++4+%3D%3E+%27cate_id%27%2C%0A++5+%3D%3E+%27area_id%27%2C%0A++6+%3D%3E+%27keys_id%27%2C%0A++7+%3D%3E+%27conf_id%27%2C%0A++8+%3D%3E+%27content%27%2C%0A++9+%3D%3E+%27mode_id%27%2C%0A++10+%3D%3E+%27perm_id%27%2C%0A++11+%3D%3E+%27ref_id%27%2C%0A++12+%3D%3E+%27order_id%27%2C%0A++13+%3D%3E+%27url%27%2C%0A++14+%3D%3E+%27time%27%2C%0A%29&typeList=array%2B%2528%250A%2B%2B0%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B1%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B2%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B3%2B%253D%253E%2B%2527INT%2527%252C%250A%2B%2B4%2B%253D%253E%2B%2527INT%2527%252C%250A%2B%2B5%2B%253D%253E%2B%2527INT%2527%252C%250A%2B%2B6%2B%253D%253E%2B%2527BIGINT%2527%252C%250A%2B%2B7%2B%253D%253E%2B%2527INT%2527%252C%250A%2B%2B8%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B9%2B%253D%253E%2B%2527TINYINT%2527%252C%250A%2B%2B10%2B%253D%253E%2B%2527TINYINT%2527%252C%250A%2B%2B11%2B%253D%253E%2B%2527BIGINT%2527%252C%250A%2B%2B12%2B%253D%253E%2B%2527INT%2527%252C%250A%2B%2B13%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B14%2B%253D%253E%2B%2527TIMESTAMP%2527%252C%250A%2529
*/
include_once('class.pog_base.php');
class contents extends POG_Base
{
	public $contentsId = '';

	/**
	 * @var VARCHAR(255)
	 */
	public $title;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $desc;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $nickname;
	
	/**
	 * @var INT
	 */
	public $user_id;
	
	/**
	 * @var INT
	 */
	public $cate_id;
	
	/**
	 * @var INT
	 */
	public $area_id;
	
	/**
	 * @var BIGINT
	 */
	public $keys_id;
	
	/**
	 * @var INT
	 */
	public $conf_id;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $content;
	
	/**
	 * @var TINYINT
	 */
	public $mode_id;
	
	/**
	 * @var TINYINT
	 */
	public $perm_id;
	
	/**
	 * @var BIGINT
	 */
	public $ref_id;
	
	/**
	 * @var INT
	 */
	public $order_id;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $url;
	
	/**
	 * @var TIMESTAMP
	 */
	public $time;
	
	public $pog_attribute_type = array(
		"contentsId" => array('db_attributes' => array("NUMERIC", "INT")),
		"title" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"desc" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"nickname" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"user_id" => array('db_attributes' => array("NUMERIC", "INT")),
		"cate_id" => array('db_attributes' => array("NUMERIC", "INT")),
		"area_id" => array('db_attributes' => array("NUMERIC", "INT")),
		"keys_id" => array('db_attributes' => array("NUMERIC", "BIGINT")),
		"conf_id" => array('db_attributes' => array("NUMERIC", "INT")),
		"content" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"mode_id" => array('db_attributes' => array("NUMERIC", "TINYINT")),
		"perm_id" => array('db_attributes' => array("NUMERIC", "TINYINT")),
		"ref_id" => array('db_attributes' => array("NUMERIC", "BIGINT")),
		"order_id" => array('db_attributes' => array("NUMERIC", "INT")),
		"url" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"time" => array('db_attributes' => array("NUMERIC", "TIMESTAMP")),
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
	
	function contents($title='', $desc='', $nickname='', $user_id='', $cate_id='', $area_id='', $keys_id='', $conf_id='', $content='', $mode_id='', $perm_id='', $ref_id='', $order_id='', $url='', $time='')
	{
		$this->title = $title;
		$this->desc = $desc;
		$this->nickname = $nickname;
		$this->user_id = $user_id;
		$this->cate_id = $cate_id;
		$this->area_id = $area_id;
		$this->keys_id = $keys_id;
		$this->conf_id = $conf_id;
		$this->content = $content;
		$this->mode_id = $mode_id;
		$this->perm_id = $perm_id;
		$this->ref_id = $ref_id;
		$this->order_id = $order_id;
		$this->url = $url;
		$this->time = $time;
	}
	
	
	/**
	* Gets object from database
	* @param integer $contentsId 
	* @return object $contents
	*/
	function Get($contentsId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `contents` where `contentsid`='".intval($contentsId)."' LIMIT 1";
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->contentsId = $row['contentsid'];
			$this->title = $this->Unescape($row['title']);
			$this->desc = $this->Unescape($row['desc']);
			$this->nickname = $this->Unescape($row['nickname']);
			$this->user_id = $this->Unescape($row['user_id']);
			$this->cate_id = $this->Unescape($row['cate_id']);
			$this->area_id = $this->Unescape($row['area_id']);
			$this->keys_id = $this->Unescape($row['keys_id']);
			$this->conf_id = $this->Unescape($row['conf_id']);
			$this->content = $this->Unescape($row['content']);
			$this->mode_id = $this->Unescape($row['mode_id']);
			$this->perm_id = $this->Unescape($row['perm_id']);
			$this->ref_id = $this->Unescape($row['ref_id']);
			$this->order_id = $this->Unescape($row['order_id']);
			$this->url = $this->Unescape($row['url']);
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
	* @return array $contentsList
	*/
	function GetList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$connection = Database::Connect();
		$sqlLimit = ($limit != '' ? "LIMIT $limit" : '');
		$this->pog_query = "select * from `contents` ";
		$contentsList = Array();
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
			$sortBy = "contentsid";
		}
		$this->pog_query .= " order by ".$sortBy." ".($ascending ? "asc" : "desc")." $sqlLimit";
		$thisObjectName = get_class($this);
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$contents = new $thisObjectName();
			$contents->contentsId = $row['contentsid'];
			$contents->title = $this->Unescape($row['title']);
			$contents->desc = $this->Unescape($row['desc']);
			$contents->nickname = $this->Unescape($row['nickname']);
			$contents->user_id = $this->Unescape($row['user_id']);
			$contents->cate_id = $this->Unescape($row['cate_id']);
			$contents->area_id = $this->Unescape($row['area_id']);
			$contents->keys_id = $this->Unescape($row['keys_id']);
			$contents->conf_id = $this->Unescape($row['conf_id']);
			$contents->content = $this->Unescape($row['content']);
			$contents->mode_id = $this->Unescape($row['mode_id']);
			$contents->perm_id = $this->Unescape($row['perm_id']);
			$contents->ref_id = $this->Unescape($row['ref_id']);
			$contents->order_id = $this->Unescape($row['order_id']);
			$contents->url = $this->Unescape($row['url']);
			$contents->time = $row['time'];
			$contentsList[] = $contents;
		}
		return $contentsList;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $contentsId
	*/
	function Save()
	{
		$connection = Database::Connect();
		$this->pog_query = "select `contentsid` from `contents` where `contentsid`='".$this->contentsId."' LIMIT 1";
		$rows = Database::Query($this->pog_query, $connection);
		if ($rows > 0)
		{
			$this->pog_query = "update `contents` set 
			`title`='".$this->Escape($this->title)."', 
			`desc`='".$this->Escape($this->desc)."', 
			`nickname`='".$this->Escape($this->nickname)."', 
			`user_id`='".$this->Escape($this->user_id)."', 
			`cate_id`='".$this->Escape($this->cate_id)."', 
			`area_id`='".$this->Escape($this->area_id)."', 
			`keys_id`='".$this->Escape($this->keys_id)."', 
			`conf_id`='".$this->Escape($this->conf_id)."', 
			`content`='".$this->Escape($this->content)."', 
			`mode_id`='".$this->Escape($this->mode_id)."', 
			`perm_id`='".$this->Escape($this->perm_id)."', 
			`ref_id`='".$this->Escape($this->ref_id)."', 
			`order_id`='".$this->Escape($this->order_id)."', 
			`url`='".$this->Escape($this->url)."', 
			`time`='".$this->time."' where `contentsid`='".$this->contentsId."'";
		}
		else
		{
			$this->pog_query = "insert into `contents` (`title`, `desc`, `nickname`, `user_id`, `cate_id`, `area_id`, `keys_id`, `conf_id`, `content`, `mode_id`, `perm_id`, `ref_id`, `order_id`, `url`, `time` ) values (
			'".$this->Escape($this->title)."', 
			'".$this->Escape($this->desc)."', 
			'".$this->Escape($this->nickname)."', 
			'".$this->Escape($this->user_id)."', 
			'".$this->Escape($this->cate_id)."', 
			'".$this->Escape($this->area_id)."', 
			'".$this->Escape($this->keys_id)."', 
			'".$this->Escape($this->conf_id)."', 
			'".$this->Escape($this->content)."', 
			'".$this->Escape($this->mode_id)."', 
			'".$this->Escape($this->perm_id)."', 
			'".$this->Escape($this->ref_id)."', 
			'".$this->Escape($this->order_id)."', 
			'".$this->Escape($this->url)."', 
			'".$this->time."' )";
		}
		$insertId = Database::InsertOrUpdate($this->pog_query, $connection);
		if ($this->contentsId == "")
		{
			$this->contentsId = $insertId;
		}
		return $this->contentsId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $contentsId
	*/
	function SaveNew()
	{
		$this->contentsId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$connection = Database::Connect();
		$this->pog_query = "delete from `contents` where `contentsid`='".$this->contentsId."'";
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
			$pog_query = "delete from `contents` where ";
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