<?php

class CacheTest extends WebTestCase
{
	public $fixtures=array(
		'caches'=>'Cache',
	);

	public function testShow()
	{
		$this->open('?r=cache/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=cache/create');
	}

	public function testUpdate()
	{
		$this->open('?r=cache/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=cache/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=cache/index');
	}

	public function testAdmin()
	{
		$this->open('?r=cache/admin');
	}
}
