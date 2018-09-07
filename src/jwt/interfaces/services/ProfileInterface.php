<?php

namespace yii2lab\extension\jwt\interfaces\services;

use yii2lab\domain\interfaces\services\CrudInterface;

/**
 * Interface ProfileInterface
 * 
 * @package yii2lab\extension\jwt\interfaces\services
 * 
 * @property-read \yii2lab\extension\jwt\Domain $domain
 * @property-read \yii2lab\extension\jwt\interfaces\repositories\ProfileInterface $repository
 */
interface ProfileInterface extends CrudInterface {

}
