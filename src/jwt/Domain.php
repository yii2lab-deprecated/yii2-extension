<?php

namespace yii2lab\extension\jwt;

use yii2lab\app\domain\helpers\EnvService;
use yii2lab\domain\enums\Driver;

/**
 * Class Domain
 * 
 * @package yii2lab\extension\jwt
 * @property-read \yii2lab\extension\jwt\interfaces\services\JwtInterface $jwt
 * @property-read \yii2lab\extension\jwt\interfaces\repositories\RepositoriesInterface $repositories
 */
class Domain extends \yii2lab\domain\Domain {
	
	public function config() {
		return [
			'repositories' => [
                'jwt' => 'jwt',
                'profile' => Driver::ENV,
			],
			'services' => [
                'jwt',
			],
		];
	}
	
}