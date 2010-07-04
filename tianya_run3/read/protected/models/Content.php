<?php

class Content extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'Content':
	 * @var integer $contentid
	 * @var integer $info_id
	 * @var integer $pg_id
	 * @var integer $page_num
	 * @var string $channel_cn
	 * @var string $url
	 * @var string $dir
	 * @var string $time
	 * @var integer $posts
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return Content the static model class
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
		return 'Content';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('info_id, pg_id, page_num, channel_cn, url, dir, time, posts', 'required'),
			array('info_id, pg_id, page_num, posts', 'numerical', 'integerOnly'=>true),
			array('channel_cn, url, dir', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('contentid, info_id, pg_id, page_num, channel_cn, url, dir, time, posts', 'safe', 'on'=>'search'),
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
			'contentid' => 'Contentid',
			'info_id' => 'Info',
			'pg_id' => 'Pg',
			'page_num' => 'Page Num',
			'channel_cn' => 'Channel Cn',
			'url' => 'Url',
			'dir' => 'Dir',
			'time' => 'Time',
			'posts' => 'Posts',
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

		$criteria->compare('contentid',$this->contentid);

		$criteria->compare('info_id',$this->info_id);

		$criteria->compare('pg_id',$this->pg_id);

		$criteria->compare('page_num',$this->page_num);

		$criteria->compare('channel_cn',$this->channel_cn,true);

		$criteria->compare('url',$this->url,true);

		$criteria->compare('dir',$this->dir,true);

		$criteria->compare('time',$this->time,true);

		$criteria->compare('posts',$this->posts);

		return new CActiveDataProvider('Content', array(
			'criteria'=>$criteria,
		));
	}
}