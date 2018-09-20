<?php

namespace yii2lab\extension\web\behaviors\action;

use yii\base\Behavior;
use yii2lab\extension\web\enums\ActionEventEnum;
use yii2lab\extension\web\events\ActionEvent;

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
	
	public function beforeWrite(ActionEvent $event) {
		
	}
	
	public function afterWrite(ActionEvent $event) {
		
	}
	
	public function beforeRead(ActionEvent $event) {
		
	}
	
	public function afterRead(ActionEvent $event) {
		
	}
	
	public function beforeDelete(ActionEvent $event) {
		
	}
	
	public function afterDelete(ActionEvent $event) {
		
	}
}
