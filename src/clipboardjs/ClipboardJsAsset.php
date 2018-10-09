<?php

namespace yii2lab\extension\clipboardJs;

use yii\web\AssetBundle;

class ClipboardJsAsset extends AssetBundle
{
	public $baseUrl = 'https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0';
	public $js = [
		'clipboard.min.js',
	];
	
	public function init() {
		\Yii::$app->view->registerJs(<<<JS
			$('document').ready(function(){
				var btns = document.querySelectorAll('.btn-copy');
				new ClipboardJS(btns);
			});
JS
		);
	}
}
