<?php

namespace yii2lab\extension\code\helpers\parser;

class DocCommentHelper
{
	
	const TYPE_EMPTY = 'empty';
	const TYPE_STRING = 'string';
	const TYPE_ATTRIBUTE = 'attribute';
	
	public static function generate($entity) {
		$lines = [];
		if(!empty($entity['title'])) {
			foreach($entity['title'] as $item) {
				$lines[] = $item;
			}
			$lines[] = EMP;
		}
		if(!empty($entity['description'])) {
			foreach($entity['description'] as $item) {
				$lines[] = $item;
			}
			$lines[] = EMP;
		}
		if(!empty($entity['attributes'])) {
			foreach($entity['attributes'] as $item) {
				$lines[] = '@' . $item['name'] . SPC . implode(SPC, $item['value']);
			}
		}
		foreach($lines as &$line) {
			$line = ' * ' . $line;
		}
		$code = '/**' . PHP_EOL;
		$code .= implode(PHP_EOL, $lines);
		$code .= PHP_EOL . '*/';
		return $code;
	}
	
	public static function parse($text) {
		$lines = self::toLines($text);
		$lines =  self::removeDoubleEmptyLines($lines);
		$collection = self::getCollection($lines);
		$entity = self::getEntity($collection);
		return $entity;
	}
	
	private static function getEntity($collection) {
		$entity = [];
		
		if($collection[0]['type'] == self::TYPE_STRING) {
			$i = 0;
			while($collection[$i]['type'] == self::TYPE_STRING) {
				$entity['title'][] = $collection[$i]['value'];
				unset($collection[$i]);
				$i++;
			}
			$collection = array_values($collection);
		}
		
		if($collection[0]['type'] == self::TYPE_EMPTY && $collection[1]['type'] == self::TYPE_STRING) {
			unset($collection[0]);
			$i = 1;
			while($collection[$i]['type'] == self::TYPE_STRING || $collection[$i]['type'] == self::TYPE_EMPTY) {
				$entity['description'][] = $collection[$i]['value'];
				unset($collection[$i]);
				$i++;
			}
			$lastIndex = count($entity['description'])-1;
			if(empty($entity['description'][$lastIndex]['type'])) {
				unset($entity['description'][$lastIndex]);
			}
			$collection = array_values($collection);
		}
		
		$attributes = array_values($collection);
		
		foreach($attributes as $k => $attribute) {
			if($attribute['type'] == self::TYPE_EMPTY) {
				unset($attributes[$k]);
			}
		}
		
		$attributes = array_values($attributes);
		
		$entity['attributes'] = $attributes;
		return $entity;
	}
	
	private static function getCollection($lines) {
		$collection = [];
		foreach($lines as $line) {
			$arr = explode(SPC, $line);
			if($arr[0]{0} == '@') {
				$collection[] = [
					'type' => self::TYPE_ATTRIBUTE,
					'name' => substr($arr[0], 1),
					'value' => array_slice($arr, 1),
				];
			} else {
				if(empty($line)) {
					$collection[] = [
						'type' => self::TYPE_EMPTY,
					];
				} else {
					$collection[] = [
						'type' => self::TYPE_STRING,
						'value' => $line,
					];
				}
			}
		}
		return $collection;
	}
	
	private static function removeDoubleEmptyLines($lines) {
		$newLines = [];
		foreach($lines as $k => $line) {
			$isEmptyPrevLine = empty($line) && isset($lines[$k-1]) && empty($lines[$k-1]);
			if(!$isEmptyPrevLine) {
				$newLines[] = $line;
			}
		}
		return $newLines;
	}
	
	private static function toLines($text) {
		$text = trim($text, ' */');
		$text = trim($text);
		$lines = explode(PHP_EOL, $text);
		foreach($lines as &$line) {
			$line = ltrim($line, '* ');
			$line = trim($line);
		}
		return $lines;
	}
	
}
