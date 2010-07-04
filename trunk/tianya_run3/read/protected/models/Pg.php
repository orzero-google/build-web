<?php

class Pg extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'Pg':
	 * @var integer $pgid
	 * @var string $name
	 * @var string $url
	 * @var string $dir
	 * @var integer $type
	 * @var string $form_vars
	 * @var integer $fid
	 * @var integer $tid
	 * @var string $time
	 * @var integer $page_size
	 * @var integer $cache_size
	 * @var integer $state
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return Pg the static model class
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
		return 'Pg';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, url, dir, type, form_vars, fid, tid, time, page_size, cache_size, state', 'required'),
			array('type, fid, tid, page_size, cache_size, state', 'numerical', 'integerOnly'=>true),
			array('name, url, dir, form_vars', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pgid, name, url, dir, type, form_vars, fid, tid, time, page_size, cache_size, state', 'safe', 'on'=>'search'),
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
			'pgid' => 'Pgid',
			'name' => 'Name',
			'url' => 'Url',
			'dir' => 'Dir',
			'type' => 'Type',
			'form_vars' => 'Form Vars',
			'fid' => 'Fid',
			'tid' => 'Tid',
			'time' => 'Time',
			'page_size' => 'Page Size',
			'cache_size' => 'Cache Size',
			'state' => 'State',
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

		$criteria->compare('pgid',$this->pgid);

		$criteria->compare('name',$this->name,true);

		$criteria->compare('url',$this->url,true);

		$criteria->compare('dir',$this->dir,true);

		$criteria->compare('type',$this->type);

		$criteria->compare('form_vars',$this->form_vars,true);

		$criteria->compare('fid',$this->fid);

		$criteria->compare('tid',$this->tid);

		$criteria->compare('time',$this->time,true);

		$criteria->compare('page_size',$this->page_size);

		$criteria->compare('cache_size',$this->cache_size);

		$criteria->compare('state',$this->state);

		return new CActiveDataProvider('Pg', array(
			'criteria'=>$criteria,
		));
	}
}