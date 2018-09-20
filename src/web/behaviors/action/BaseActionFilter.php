<?php

namespace yii2lab\extension\web\behaviors\action;

use yii\base\Behavior;
use yii2lab\domain\events\DataEvent;
use yii2lab\extension\web\enums\ActionEventEnum;

abstract class BaseActionFilter extends Behavior
{
	
	public function events()
	{
		return [
			ActionEventEnum::BEFORE_WRITE => 'beforeWrite',
			ActionEventEnum::AFTER_WRITE => 'afterWrite',
			
			ActionEventEnum::BEFORE_READ => 'beforeRead',
			ActionEventEnum::AFTER_READ => 'afterRead',
			
			ActionEventEnum::BEFORE_DELETE => 'beforeDelete',
			ActionEventEnum::AFTER_DELETE => 'afterDelete',
		];
	}
	
	public function beforeWrite(DataEvent $event) {
		
	}
	
	public function afterWrite(DataEvent $event) {
		
	}
	
	public function beforeRead(DataEvent $event) {
		
	}
	
	public function afterRead(DataEvent $event) {
		
	}
	
	public function beforeDelete(DataEvent $event) {
		
	}
	
	public function afterDelete(DataEvent $event) {
		
	}
}
