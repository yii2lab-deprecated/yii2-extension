<?php
namespace tests\unit\helpers;

use yii2lab\test\Test\Unit;
use yii2lab\extension\store\Store;

class StoreTest extends Unit
{
	
	public $encoded = '{"name":"John","balance":{"active":100}}';
	public $decoded = [
		'name' => 'John',
		'balance' => [
			'active' => 100
		]
	];
	
	public function testEncode()
	{
		$store = new Store('Json');
		$result = $store->encode($this->decoded);
		$result = preg_replace('#\s+#', '', $result);
		$this->tester->assertEquals($result, $this->encoded);
	}
	
	public function testDecode()
	{
		$store = new Store('Json');
		$result = $store->decode($this->encoded);
		$this->tester->assertEquals($result, $this->decoded);
	}
	
	public function testSave()
	{
		$store = new Store('Json');
		$fileName = $this->fileName('temp');
		$store->save($fileName, $this->decoded);
		$result = $store->load($fileName);
		$this->tester->assertEquals($result, $this->decoded);
	}
	
	public function testUpdate()
	{
		$this->loadFixture();
		$store = new Store('Json');
		$fileName = $this->fileName('example');
		$store->update($fileName, 'balance.active', 200);
		$result = $store->load($fileName, 'balance.active');
		$this->tester->assertEquals($result, 200);
	}

	public function testLoad()
	{
		$this->loadFixture();
		$store = new Store('Json');
		$fileName = $this->fileName('example');
		$result = $store->load($fileName);
		$this->tester->assertEquals($result, $this->decoded);
	}
	
	public function testLoadWithKey()
	{
		$this->loadFixture();
		$store = new Store('Json');
		$fileName = $this->fileName('example');
		$result = $store->load($fileName, 'name');
		$this->tester->assertEquals($result, 'John');
	}
	
	public function testLoadWithMultiKey()
	{
		$this->loadFixture();
		$store = new Store('Json');
		$fileName = $this->fileName('example');
		$result = $store->load($fileName, 'balance.active');
		$this->tester->assertEquals($result, 100);
	}
	
	private function fileName($name)
	{
		$fileName = codecept_data_dir() . DS . $name . '.json';
		return $fileName;
	}
	
	private function loadFixture()
	{
		$fileName = $this->fileName('example');
		file_put_contents($fileName, $this->encoded);
	}
}
