<?php

namespace yii2lab\extension\git\domain\services;

use yii2lab\extension\git\domain\interfaces\services\GitInterface;
use yii2lab\domain\services\base\BaseActiveService;

/**
 * Class GitService
 * 
 * @package yii2lab\extension\git\domain\services
 * 
 * @property-read \yii2lab\extension\git\domain\Domain $domain
 * @property-read \yii2lab\extension\git\domain\interfaces\repositories\GitInterface $repository
 */
class GitService extends BaseActiveService implements GitInterface {
	
	public function oneByDir($dir) {
		return $this->repository->oneByDir($dir);
	}
	
}
