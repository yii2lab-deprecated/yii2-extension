<?php

namespace yii2lab\extension\package\domain\services;

use yii2lab\extension\package\domain\interfaces\services\ConfigInterface;
use yii2lab\domain\services\base\BaseActiveService;

/**
 * Class ConfigService
 * 
 * @package yii2lab\extension\package\domain\services
 * 
 * @property-read \yii2lab\extension\package\domain\Domain $domain
 * @property-read \yii2lab\extension\package\domain\interfaces\repositories\ConfigInterface $repository
 */
class ConfigService extends BaseActiveService implements ConfigInterface {
	
	public function oneByDir($dir) {
		return $this->repository->oneByDir($dir);
	}
	
}
