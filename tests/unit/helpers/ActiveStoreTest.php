<?php
namespace tests\unit\helpers;

use yii2lab\test\Test\Unit;
use yii2lab\extension\tests\models\Login;

class ActiveStoreTest extends Unit
{
	
	public function testOne()
	{
		$result = Login::one(['login' => '77004163092']);
		$this->tester->assertEquals($result, [
			'login' => '77004163092',
			'role' => 'rAdministrator',
			'is_active' => 1,
		]);
	}
	
	public function testAll()
	{
		$result = Login::all(['is_active' => 1]);
		$this->tester->assertEquals($result, [
			[
				'login' => '77004163092',
				'role' => 'rAdministrator',
				'is_active' => 1,
			],
			[
				'login' => '77783177384',
				'role' => 'rUnknownUser',
				'is_active' => 1,
			],
		]);
	}
	
}
