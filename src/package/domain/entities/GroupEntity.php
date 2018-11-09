<?php

namespace yii2lab\extension\package\domain\entities;

use yii\helpers\ArrayHelper;
use yii2lab\domain\BaseEntity;

/**
 * Class GroupEntity
 * 
 * @package yii2lab\extension\package\domain\entities
 *
 * @property $name
 * @property $provider
 * @property $url
 * @property $authors
 */
class GroupEntity extends BaseEntity {
	
	protected $name;
	protected $provider;
	protected $url;
	protected $authors;

	
	
	/*public function getUrl() {
		if(!empty($this->url)) {
			return $this->url;
		}
		$arr = [
			'github' => 'https://github.com',
		];
		return ArrayHelper::getValue($arr, $this->provider);
	}*/
	
}
