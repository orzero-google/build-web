<?php

class Info extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'Info':
	 * @var integer $infoid
	 * @var string $name
	 * @var integer $type
	 * @var string $channel_en
	 * @var string $channel_cn
	 * @var string $title
	 * @var integer $author_id
	 * @var string $author_name
	 * @var string $pid_list
	 * @var integer $count
	 * @var string $time
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return Info the static model class
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
		return 'Info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, type, channel_en, channel_cn, title, author_id, author_name, pid_list, count, time', 'required'),
			array('type, author_id, count', 'numerical', 'integerOnly'=>true),
			array('name, channel_en, channel_cn, title, author_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('infoid, name, type, channel_en, channel_cn, title, author_id, author_name, pid_list, count, time', 'safe', 'on'=>'search'),
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
			'infoid' => 'Infoid',
			'name' => 'Name',
			'type' => 'Type',
			'channel_en' => 'Channel En',
			'channel_cn' => 'Channel Cn',
			'title' => 'Title',
			'author_id' => 'Author',
			'author_name' => 'Author Name',
			'pid_list' => 'Pid List',
			'count' => 'Count',
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

		$criteria->compare('infoid',$this->infoid);

		$criteria->compare('name',$this->name,true);

		$criteria->compare('type',$this->type);

		$criteria->compare('channel_en',$this->channel_en,true);

		$criteria->compare('channel_cn',$this->channel_cn,true);

		$criteria->compare('title',$this->title,true);

		$criteria->compare('author_id',$this->author_id);

		$criteria->compare('author_name',$this->author_name,true);

		$criteria->compare('pid_list',$this->pid_list,true);

		$criteria->compare('count',$this->count);

		$criteria->compare('time',$this->time,true);

		return new CActiveDataProvider('Info', array(
			'criteria'=>$criteria,
		));
	}
}