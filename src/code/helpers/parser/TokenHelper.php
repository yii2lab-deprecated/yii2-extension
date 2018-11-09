<?php

namespace yii2lab\extension\code\helpers\parser;

use yii2lab\extension\code\entities\TokenEntity;
use yii2lab\extension\yii\helpers\FileHelper;

class TokenHelper
{
	
	public static function trimCollection($collection, $charList = " \t\n\r\0\x0B") {
		/** @var TokenEntity[] $collection */
		foreach($collection as &$item) {
			$item->value = trim($item->value, $charList);
		}
		return $collection;
	}
	
	public static function save($fileName, $collection) {
		$code =  self::collectionToCode($collection);
		FileHelper::save($fileName, $code);
	}
	
	public static function load($fileName) {
		$code = FileHelper::load($fileName);
		$code = $code ? $code : EMP;
		return self::codeToCollection($code);
	}
	
	/**
	 * @param string $code
	 *
	 * @return TokenEntity[]
	 */
	public static function codeToCollection(string $code) {
		$tokens = token_get_all($code);
		//prr($tokens,1,1);
		$tokenCollection = [];
		foreach($tokens as $token) {
			$entity = new TokenEntity();
			if(is_array($token)) {
				$entity->type = $token[0];
				$entity->value = $token[1];
				$entity->line = $token[2];
			} else {
				$entity->type = 0;
				$entity->value = $token;
				//$entity->line = $token[2];
			}
			$tokenCollection[] = $entity;
		}
		return $tokenCollection;
	}
	
	public static function collectionToCode(array $tokenCollection) {
		$code = EMP;
		/** @var TokenEntity[] $tokenCollection */
		foreach($tokenCollection as $entity) {
			$code .= $entity->value;
		}
		return $code;
	}
	
}
