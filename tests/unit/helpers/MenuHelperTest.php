<?php
namespace tests\unit\helpers;

use yii2lab\test\Test\Unit;
use yii2lab\extension\menu\helpers\MenuHelper;
use yii2lab\test\helpers\DataHelper;
use yii2module\account\domain\v2\helpers\TestAuthHelper;

class MenuHelperTest extends Unit
{
	
	const PACKAGE = 'yii2lab/yii2-extension';
	const ADMIN_ID = 381949;
	const USER_ID = 381070;
	
	public function testGenerateMenu()
	{
		$menu = DataHelper::load(self::PACKAGE, 'store/source/menu.php');
		$resultMenu = MenuHelper::gen($menu);
		$expect = DataHelper::load(self::PACKAGE, 'store/expect/generatedMenu.php', $resultMenu);
		$this->tester->assertEquals($expect, $resultMenu);
	}
	
	public function testGenerateMenuAccess()
	{
		TestAuthHelper::authById(self::ADMIN_ID);
		$menu = [
			[
				'label' => ['lang/main', 'title'],
				'url' => 'lang/manage',
				'icon' => 'language',
				'access' => 'oLangManage',
			],
		];
		
		$resultMenu = MenuHelper::gen($menu);
		$expect = DataHelper::load(self::PACKAGE, 'store/expect/generatedMenuForDomain.php', $resultMenu);
		$this->tester->assertEquals($expect, $resultMenu);
	}
	
	public function testGenerateMenuAccessForbidden()
	{
		TestAuthHelper::authById(self::USER_ID);
		$menu = [
			[
				'label' => ['lang/main', 'title'],
				'url' => 'lang/manage',
				'icon' => 'language',
				'access' => 'oLangManage',
			],
		];
		
		$resultMenu = MenuHelper::gen($menu);
		$this->tester->assertEquals([], $resultMenu);
	}
	
	public function testGenerateMenuAccessForbidden1()
	{
		TestAuthHelper::defineAccountDomain();
		$menu = [
			[
				'label' => ['lang/main', 'title'],
				'url' => 'lang/manage',
				'icon' => 'language',
				'access' => 'oLangManage',
			],
		];
		
		$resultMenu = MenuHelper::gen($menu);
		$this->tester->assertEquals([], $resultMenu);
	}
	
	public function testRenderMenu()
	{
		$menu = DataHelper::load(self::PACKAGE, 'store/source/simpleMenu.php');
		$resultMenu = MenuHelper::renderMenu($menu);
		$expect = DataHelper::load(self::PACKAGE, 'store/expect/renderedMenu.php', $resultMenu);
		$this->tester->assertEquals($expect, $resultMenu);
	}
	
}
