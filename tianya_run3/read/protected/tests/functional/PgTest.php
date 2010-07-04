<?php

class PgTest extends WebTestCase
{
	public $fixtures=array(
		'pgs'=>'Pg',
	);

	public function testShow()
	{
		$this->open('?r=pg/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=pg/create');
	}

	public function testUpdate()
	{
		$this->open('?r=pg/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=pg/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=pg/index');
	}

	public function testAdmin()
	{
		$this->open('?r=pg/admin');
	}
}
