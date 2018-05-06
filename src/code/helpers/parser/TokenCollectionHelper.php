<?php

namespace yii2lab\extension\code\helpers\parser;

use yii2lab\designPattern\scenario\helpers\ScenarioHelper;
use yii2lab\extension\code\filters\parser\DocCommentOnly;
use yii2lab\extension\code\filters\parser\RemoveComment;
use yii2lab\extension\code\filters\parser\RemoveDoubleEmptyLines;
use yii2lab\extension\code\filters\parser\ToLine;

class TokenCollectionHelper {
	
	public static function getDocCommentCollection($collection) {
		$filterCollection = [
			DocCommentOnly::class,
		];
		return self::applyFilters($collection, $filterCollection);
	}
	
	public static function compress($collection) {
		$filterCollection = [
			RemoveComment::class,
			RemoveDoubleEmptyLines::class,
			ToLine::class,
		];
		return self::applyFilters($collection, $filterCollection);
	}
	
	public static function unCompress($collection) {
	
	}
	
	public static function applyFilters($collection, $filters) {
		$filterCollection = ScenarioHelper::forgeCollection($filters);
		return ScenarioHelper::runAll($filterCollection, $collection);
	}
	
}
