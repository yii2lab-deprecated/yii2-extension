<?php

namespace yii2lab\extension\activeRecord\helpers;

use yii\base\InvalidArgumentException;
use yii2lab\domain\data\Query;
use yii2lab\domain\exceptions\UnprocessableEntityHttpException;
use yii2lab\domain\helpers\ErrorCollection;

class SearchHelper {
	
	const SEARCH_TEXT_MIN_LENGTH = 3;
	const SEARCH_PARAM_NAME = 'search-text';
	
	public static function extractSearchTextFromQuery(Query $query) {
		$searchText = $query->getWhere(self::SEARCH_PARAM_NAME);
		if(empty($searchText)) {
			return null;
		}
		$query->removeWhere(self::SEARCH_PARAM_NAME);
		$searchText = trim($searchText);
		return $searchText;
	}
	
	public static function appendSearchCondition(Query $query, $searchByTextFields, $searchText) {
		//$searchText = self::extractSearchTextFromQuery($query);
		self::validateSearchText($searchText);
		$likeCondition = self::generateLikeCondition($searchText, $searchByTextFields);
		$query->andWhere($likeCondition);
	}
	
	private static function generateLikeCondition($text, $searchByTextFields) {
		if(empty($searchByTextFields)) {
			throw new InvalidArgumentException('Method "searchByTextFields" return empty array!');
		}
		$q = Query::forge();
		foreach($searchByTextFields as $key) {
			$q->orWhere(['ilike', $key, $text]);
		}
		return $q->getParam('where');
	}
	
	private static function validateSearchText($text) {
		$text = trim($text);
		if(empty($text) || mb_strlen($text) < self::SEARCH_TEXT_MIN_LENGTH) {
			$error = new ErrorCollection;
			$error->add('text', 'yii', '{attribute} should contain at least {min, number} {min, plural, one{character} other{characters}}.', [
				'attribute'=>'text',
				'min'=>self::SEARCH_TEXT_MIN_LENGTH,
			]);
			throw new UnprocessableEntityHttpException($error);
		}
	}
	
}