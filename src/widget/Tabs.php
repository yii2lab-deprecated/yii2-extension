<?php

namespace yii2lab\extension\widget;

use yii\base\Widget;
use yii\bootstrap\Nav;
use yii2lab\extension\menu\helpers\MenuHelper;

/**
 * Class Tabs
 *
 * @package yii2lab\extension\widget
 *
 * @deprecated
 */
class Tabs extends Widget
{

	public $id = 'tabs_navigation';
    public $items = [];
	
	public function run() {
		echo Nav::widget([
			'options' => [
				'id' => $this->id,
                'class' => 'nav nav-tabs',
            ],
			'items' => $this->items,
		]);
	}

}
