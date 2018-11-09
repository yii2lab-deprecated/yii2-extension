<?php

namespace yii2lab\extension\package\console\controllers;

use yii2lab\extension\console\helpers\Alert;
use yii2lab\extension\console\helpers\input\Enter;
use yii2lab\extension\console\helpers\Output;
use yii2lab\extension\console\base\Controller;
use yii2lab\extension\package\domain\entities\PackageEntity;
use yii2lab\extension\package\helpers\ConfigHelper;
use yii2lab\extension\package\helpers\PackageHelper;

class PackageController extends Controller {
	
	public function init() {
		parent::init();
		Output::line();
	}
	
	public function actionAll() {
		$collection = \App::$domain->package->package->all();
		
		prr($collection,1,1);
	}
	
	public function actionDownload() {
		$group = Enter::display('Vendor name');
		$package = Enter::display('Package name');
		PackageHelper::forge($group, $package);
		Alert::success('Package downloaded and installed!');
	}
	
	public function actionInstall() {
		$group = Enter::display('Vendor name');
		$package = Enter::display('Package name');
		ConfigHelper::addPackage($group, $package);
		Alert::success('Package installed!');
	}
	
}
