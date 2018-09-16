<?php
namespace tests\unit\helpers;

use yii2lab\test\Test\Unit;
use yii2lab\extension\registry\helpers\Registry;

class RegistryTest extends Unit
{
	
	public function testGetStartValues()
	{
        Registry::reset();
	    $this->tester->assertEquals(Registry::get(), []);
	}
	
	public function testSetValues()
	{
		Registry::set('key1', 'value1');
		Registry::set('key2', 'value2');
		Registry::set('key3', 'value3');
	}
	
	public function testGetValue()
	{
		$this->tester->assertEquals(Registry::get('key1'), 'value1');
		$this->tester->assertEquals(Registry::get('key2'), 'value2');
		$this->tester->assertEquals(Registry::get('key3'), 'value3');
	}

	public function testGetAllValues()
	{
		$this->tester->assertEquals(Registry::get(), [
			'key1' => 'value1',
			'key2' => 'value2',
			'key3' => 'value3',
		]);
	}
	
	public function testGetNotExistsValue()
	{
		$this->tester->assertEquals(Registry::get('key4'), null);
		$this->tester->assertEquals(Registry::get('key4', 'default_value4'), 'default_value4');
	}
	
	public function testRemoveValue()
	{
		Registry::remove('key3');
		$this->tester->assertEquals(Registry::get('key3'), null);
		$this->tester->assertEquals(Registry::get('key3', 'default_value3'), 'default_value3');
	}
	
	public function testHasKey()
	{
		$this->tester->assertEquals(Registry::has('key1'), true);
		$this->tester->assertEquals(Registry::has('key3'), false);
		$this->tester->assertEquals(Registry::has('key333'), false);
	}
	
}
