<?php

namespace yii2lab\extension\package\domain;

use yii2lab\domain\enums\Driver;

/**
 * Class Domain
 * 
 * @package yii2lab\extension\package\domain
 * @property-read \yii2lab\extension\package\domain\interfaces\services\PackageInterface $package
 * @property-read \yii2lab\extension\package\domain\interfaces\repositories\RepositoriesInterface $repositories
 * @property-read \yii2lab\extension\package\domain\interfaces\services\GroupInterface $group
 */
class Domain extends \yii2lab\domain\Domain {
	
	public function config() {
		return [
			'repositories' => [
				'package' => Driver::FILE,
				'group' => Driver::FILEDB,
			],
			'services' => [
				'package',
				'group',
			],
		];
	}
	
}