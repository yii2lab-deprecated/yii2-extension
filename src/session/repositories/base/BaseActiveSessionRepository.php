<?php

namespace yii2lab\extension\session\repositories\base;

use yii2lab\domain\interfaces\repositories\CrudInterface;
use yii2lab\extension\arrayTools\traits\ArrayModifyTrait;
use yii2lab\extension\arrayTools\traits\ArrayReadTrait;

abstract class BaseActiveSessionRepository extends BaseSessionRepository implements CrudInterface {
	
	use ArrayReadTrait;
	use ArrayModifyTrait;
	
}