<?php

namespace yii2lab\extension\package\domain\services;

use yii2lab\domain\services\base\BaseActiveService;
use yii2lab\extension\package\domain\interfaces\services\PackageInterface;

/**
 * Class PackageService
 * 
 * @package yii2lab\extension\package\domain\services
 * 
 * @property-read \yii2lab\extension\package\domain\Domain $domain
 * @property-read \yii2lab\extension\package\domain\interfaces\repositories\PackageInterface $repository
 */
class PackageService extends BaseActiveService implements PackageInterface {

}
