<?php

namespace yii2lab\extension\package\domain\services;

use yii2lab\extension\package\domain\interfaces\services\GroupInterface;
use yii2lab\domain\services\base\BaseActiveService;

/**
 * Class GroupService
 * 
 * @package yii2lab\extension\package\domain\services
 * 
 * @property-read \yii2lab\extension\package\domain\Domain $domain
 * @property-read \yii2lab\extension\package\domain\interfaces\repositories\GroupInterface $repository
 */
class GroupService extends BaseActiveService implements GroupInterface {

}
