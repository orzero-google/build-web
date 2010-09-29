<?php

class Cache extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'Cache':
	 * @var integer $cacheid
	 * @var integer $pid
	 * @var integer $type
	 * @var string $furl
	 * @var string $turl
	 * @var string $file
	 * @var integer $size
	 * @var integer $status
	 * @var integer $posts
	 * @var string $time
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return Cache the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cache';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pid, type, furl, turl, file, size, status, posts, time', 'required'),
			array('pid, type, size, status, posts', 'numerical', 'integerOnly'=>true),
			array('furl, turl, file', 'length', 'max'=>1023),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cacheid, pid, type, furl, turl, file, size, status, posts, time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cacheid' => 'Cacheid',
			'pid' => 'Pid',
			'type' => 'Type',
			'furl' => 'Furl',
			'turl' => 'Turl',
			'file' => 'File',
			'size' => 'Size',
			'status' => 'Status',
			'posts' => 'Posts',
			'time' => 'Time',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('cacheid',$this->cacheid);

		$criteria->compare('pid',$this->pid);

		$criteria->compare('type',$this->type);

		$criteria->compare('furl',$this->furl,true);

		$criteria->compare('turl',$this->turl,true);

		$criteria->compare('file',$this->file,true);

		$criteria->compare('size',$this->size);

		$criteria->compare('status',$this->status);

		$criteria->compare('posts',$this->posts);

		$criteria->compare('time',$this->time,true);

		return new CActiveDataProvider('Cache', array(
			'criteria'=>$criteria,
		));
	}
}