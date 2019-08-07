<?php

namespace yii2lab\extension\core\domain\helpers;

use Yii;
use yii\base\Model;

class UserAgent extends Model
{

	/**
	 * @var string
	 */
	public $platform;

	/**
	 * @var string
	 */
	public $browser;

	/**
	 * @var string
	 */
	public $version;

	public $language;

	/**
	 * @return array
	 */
	public function rules()
	{
		return [
			[['platform', 'browser', 'version', 'language'], 'safe'],
		];
	}

	/**
	 * @param string $userAgent
	 * @return UserAgent
	 */
	public static function model($userAgent = null)
	{
		if (null === $userAgent) {
			$userAgent = static::getDefaultUserAgent();
		}
		$result = new static(parse_user_agent($userAgent));

		$result ['language'] = Yii::$app->language;

		$additionalParseData = self::parse($userAgent);
		if (empty($result['platform'])) {
			$result['platform'] = $additionalParseData[1];
			$result ['language'] = $additionalParseData[3];
		}
		if (strlen($result['browser']) < 3) {
			$result['browser'] = $additionalParseData[2];
		}
		if (empty($result['version'])) {
			$result['version'] = $additionalParseData[0];
		}

		return $result;
	}

	private static function parse(?string $userAgent)
	{
		$result = explode('|', $userAgent);
		if (count($result) == 1) {
			$result = explode(',', $userAgent);;
		}
		return $result;
	}

	/**
	 * @return string
	 */
	public static function getDefaultUserAgent()
	{
        return  Yii::$app->request->getUserAgent();
	}
}