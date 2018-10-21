<?php

namespace yii2lab\extension\code\helpers\parser;

use yii2lab\extension\code\entities\TokenEntity;
use yii2lab\extension\scenario\helpers\ScenarioHelper;
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
	
	public static function addDocComment($collection) {
		$indexes = TokenCollectionHelper::getDocCommentIndexes($collection);
		if(!empty($indexes)) {
			return $collection;
		}
		$newCollection = [];
		
		foreach($collection as $k => $entity) {
			if($entity->type == T_CLASS) {
				$docCommentEntity = new TokenEntity();
				$docCommentEntity->type = T_DOC_COMMENT;
				$docCommentEntity->value =
					'/**
 * Class Domain
 */';
				$newCollection[] = $docCommentEntity;
				
				$whitespaceEntity = new TokenEntity([
					'type' => T_WHITESPACE,
					'value' => PHP_EOL,
				]);
				$newCollection[] = $whitespaceEntity;
			}
			$newCollection[] = $entity;
		}
		return $newCollection;
	}
	
	public static function getDocCommentIndexes($collection) {
		$indexes = [];
		/** @var TokenEntity[] $collection */
		foreach($collection as $k => $entity) {
			if($entity->type == T_DOC_COMMENT) {
				$indexes[] = $k;
			}
		}
		return $indexes;
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
