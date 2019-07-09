<?php

namespace yii2lab\extension\jwt;

use yii2lab\domain\enums\Driver;

/**
 * Class Domain
 * 
 * @package yii2lab\extension\jwt
 * @property-read \yii2lab\extension\jwt\interfaces\repositories\RepositoriesInterface $repositories
 * @property-read \yii2lab\extension\jwt\interfaces\services\ProfileInterface $profile
 * @property-read \yii2lab\extension\jwt\interfaces\services\TokenInterface $token
 */
class Domain extends \yii2lab\domain\Domain {
	
	public function config() {
		return [
			'repositories' => [
                'token' =>  'jwt',
                'profile' => YII_ENV != YII_ENV_TEST ? Driver::ENV : Driver::TEST,
			],
			'services' => [
                'token',
                'profile',
			],
		];
	}
	
}