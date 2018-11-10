<?php

namespace yii2lab\extension\git\domain\interfaces\services;

use yii2lab\domain\interfaces\services\CrudInterface;

/**
 * Interface GitInterface
 * 
 * @package yii2lab\extension\git\domain\interfaces\services
 * 
 * @property-read \yii2lab\extension\git\domain\Domain $domain
 * @property-read \yii2lab\extension\git\domain\interfaces\repositories\GitInterface $repository
 */
interface GitInterface extends CrudInterface {

}
