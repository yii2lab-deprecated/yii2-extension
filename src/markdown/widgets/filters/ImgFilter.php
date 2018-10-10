<?php

namespace yii2lab\extension\markdown\widgets\filters;

use Yii;
use yii2lab\extension\scenario\base\BaseScenario;
use yii2lab\extension\yii\helpers\FileHelper;
use yii2lab\extension\yii\helpers\Html;

class ImgFilter extends BaseScenario {
	
	const FILE_NO_IMAGE = '@frontend/web/images/image/no_image.png';
	const WEB_NO_IMAGE = '@web/images/image/no_image.png';
	
	public function run() {
		$html = $this->getData();
		$html = $this->replace($html);
		$this->setData($html);
	}

	private function replace($html) {
		$project_id = Yii::$app->request->getQueryParam('project_id');
		$project = \App::$domain->guide->project->oneById($project_id);
		$pattern = '~<img src="([^"]+)"([^\>]*)>~';
		$html = preg_replace_callback($pattern, function($matches) use($project) {
			$url = $matches[1];
			if(strpos($url, '://') !== false) {
				return $matches[0];
			}
			$fileName = ROOT_DIR . DS . $project->dir . DS . $url;
			if(!FileHelper::has($fileName)) {
				$fileName = Yii::getAlias(self::FILE_NO_IMAGE);
			}
			$data = Html::getDataUrl($fileName);
			return "<img src=\"{$data}\"{$matches[2]}>";
		}, $html);
		return $html;
	}

}
