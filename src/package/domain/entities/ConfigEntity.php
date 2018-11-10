<?php

namespace yii2lab\extension\package\domain\entities;

use yii\helpers\ArrayHelper;
use yii2lab\domain\BaseEntity;
use yii2lab\domain\data\Query;

/**
 * Class ConfigEntity
 *
 * @package yii2lab\extension\package\domain\entities
 *
 * property $id
 * @property $dir
 * @property $config
 */
class ConfigEntity extends BaseEntity {
	
	//protected $id;
	protected $dir;
	protected $name;
	protected $type;
	protected $keywords;
	protected $license;
	protected $authors;
	protected $minimum_stability;
	protected $autoload;
	protected $require;
	protected $config;
	
	public function getName() {
		return ArrayHelper::getValue($this->config, 'name', '');
	}
	
	public function getType() {
		return ArrayHelper::getValue($this->config, 'type', 'yii2-extension');
	}
	
	public function getKeywords() {
		return ArrayHelper::getValue($this->config, 'keywords', [
			"yii2",
		]);
	}
	
	public function getLicense() {
		return ArrayHelper::getValue($this->config, 'license', 'MIT');
	}
	
	private function getAuthorsFromGroup() {
		$query = Query::forge();
		$query->with('group');
		/** @var PackageEntity $packageEntity */
		$packageEntity = \App::$domain->package->package->oneById($this->id, $query);
		return $packageEntity->group->authors;
	}
	
	/*public function getAuthors() {
		return ArrayHelper::getValue($this->config, 'authors', $this->getAuthorsFromGroup());
	}*/
	
	public function getMinimumStability() {
		return ArrayHelper::getValue($this->config, 'minimum-stability', 'dev');
	}
	
	public function getAutoload() {
		$baseName = str_replace(SL, BSL, $this->getName());
		$baseName = str_replace('\\yii2-', BSL, $baseName);
		return ArrayHelper::getValue($this->config, 'autoload', [
			'psr-4' => [
				$baseName . BSL => 'src',
			],
		]);
	}
	
	public function getRequire() {
		return ArrayHelper::getValue($this->config, 'require', [
			"yiisoft/yii2" => "*",
			"php" => ">=7.0.0",
		]);
	}
	
	public function setName($name) {
		$this->config['name'] = $name;
	}
	
	public function setType($type) {
		$this->config['type'] = $type;
	}
	
	public function setKeywords($keywords) {
		$this->config['keywords'] = $keywords;
	}
	
	public function setLicense($license) {
		$this->config['license'] = $license;
	}
	
	public function setAuthors($authors) {
		$this->config['authors'] = $authors;
	}
	
	public function setMinimumStability($value) {
		$this->config['minimum-stability'] = $value;
	}
	
	public function setAutoload($autoload) {
		$this->config['autoload'] = $autoload;
	}
	
	public function setRequire($require) {
		$this->config['require'] = $require;
	}
	
}
