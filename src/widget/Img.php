<?php

namespace yii2lab\extension\widget;

use yii\base\Widget;
use yii2lab\extension\yii\helpers\Html;

class Img extends Widget
{
	
	const TYPE_IMG = 'img';
	const TYPE_IMG_DATA = 'img_data';
 
	public $url;
	public $file;
	public $type;

	public function run()
	{
		if($this->type == self::TYPE_IMG) {
		    ?><img src="<?= $this->url ?>" /><?php
        } elseif($this->type == self::TYPE_IMG_DATA) {
			?><img src="<?= Html::getDataUrl($this->file) ?>" /><?php
		}
	}

}
