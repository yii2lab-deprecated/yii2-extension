<?php

namespace yii2lab\extension\widget\ajaxSelector\assets;

use yii\web\AssetBundle;

class SelectorAsset extends AssetBundle
{
	public $sourcePath = '@yii2lab/widgets/ajaxSelector/assets/dist';
	public $js = [
		'js/main.js',
	];
	public $depends = [
		'yii2lab\applicationTemplate\common\assets\main\ScriptAsset',
        'yii2lab\rest\web\assets\rest\RestAsset',
	];
}
