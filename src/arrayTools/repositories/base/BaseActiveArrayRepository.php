<?php

namespace yii2lab\extension\arrayTools\repositories\base;

use yii2lab\domain\interfaces\repositories\CrudInterface;
use yii2lab\domain\repositories\BaseRepository;
use yii2lab\extension\arrayTools\traits\ArrayModifyTrait;
use yii2lab\extension\arrayTools\traits\ArrayReadTrait;

abstract class BaseActiveArrayRepository extends BaseRepository implements CrudInterface {
	
	use ArrayReadTrait;
	use ArrayModifyTrait;
	
	private $collection = [];
	
	protected function setCollection(Array $collection) {
		$this->collection = $collection;
	}
	
	protected function getCollection() {
		return $this->collection;
	}
}
