<?php

namespace yii2lab\extension\package\console;

use yii\base\Module as YiiModule;
use yii2lab\domain\helpers\DomainHelper;

class Module extends YiiModule {
	
	public function init() {
		DomainHelper::forgeDomains([
			'package' => 'yii2lab\extension\package\domain\Domain',
		]);
		parent::init();
	}
	
}
