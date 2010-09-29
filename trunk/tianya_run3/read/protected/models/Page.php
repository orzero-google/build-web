<?php

class Page extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'Page':
	 * @var integer $pageid
	 * @var string $furl
	 * @var string $title
	 * @var string $channel_en
	 * @var string $channel_cn
	 * @var integer $author_id
	 * @var string $author_name
	 * @var integer $tpid
	 * @var integer $pcount
	 * @var string $plist
	 * @var string $time
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return Page the static model class
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
		return 'page';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('furl, title, channel_en, channel_cn, author_id, author_name, tpid, pcount, plist, time', 'required'),
			array('author_id, tpid, pcount', 'numerical', 'integerOnly'=>true),
			array('furl', 'length', 'max'=>1023),
			array('title, channel_en, channel_cn, author_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pageid, furl, title, channel_en, channel_cn, author_id, author_name, tpid, pcount, plist, time', 'safe', 'on'=>'search'),
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
			'pageid' => 'Pageid',
			'furl' => 'Furl',
			'title' => 'Title',
			'channel_en' => 'Channel En',
			'channel_cn' => 'Channel Cn',
			'author_id' => 'Author',
			'author_name' => 'Author Name',
			'tpid' => 'Tpid',
			'pcount' => 'Pcount',
			'plist' => 'Plist',
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

		$criteria->compare('pageid',$this->pageid);

		$criteria->compare('furl',$this->furl,true);

		$criteria->compare('title',$this->title,true);

		$criteria->compare('channel_en',$this->channel_en,true);

		$criteria->compare('channel_cn',$this->channel_cn,true);

		$criteria->compare('author_id',$this->author_id);

		$criteria->compare('author_name',$this->author_name,true);

		$criteria->compare('tpid',$this->tpid);

		$criteria->compare('pcount',$this->pcount);

		$criteria->compare('plist',$this->plist,true);

		$criteria->compare('time',$this->time,true);

		return new CActiveDataProvider('Page', array(
			'criteria'=>$criteria,
		));
	}
}