<?php

namespace yii2lab\extension\core\domain;

use yii2lab\domain\enums\Driver;

/**
 * Class Domain
 *
 * @package yii2lab\extension\core\domain
 *
 * @deprecated
 */
class Domain extends \yii2lab\domain\Domain {
	
	public function config() {
		return [
			'repositories' => [
				'client' => Driver::REST,
			],
			'services' => [
				'client',
			],
		];
	}
	
}