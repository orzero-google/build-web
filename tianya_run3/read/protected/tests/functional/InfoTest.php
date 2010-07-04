<?php

class InfoTest extends WebTestCase
{
	public $fixtures=array(
		'infos'=>'Info',
	);

	public function testShow()
	{
		$this->open('?r=info/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=info/create');
	}

	public function testUpdate()
	{
		$this->open('?r=info/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=info/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=info/index');
	}

	public function testAdmin()
	{
		$this->open('?r=info/admin');
	}
}
