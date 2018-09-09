<?php

namespace yii2lab\extension\widget\ajaxSelector;

use yii\base\Widget;

class AjaxSelector extends Widget
{
	public $form;
	public $model;
	public $entities = [];
	
	/**
	 * Runs the widget
	 */
	public function run()
	{
		$entities = $this->entities;
		$entities = $this->setDefault($entities);
		$entities = $this->setChild($entities);
		return $this->render('fields', [
			'form' => $this->form,
			'model' => $this->model,
			'entities' => $entities,
		]);
	}
	
	private function setDefault($entities) {
		$formId = $this->getFormId();
		foreach($entities as $name => &$entity) {
			$entity['name'] = $name;
			$entity['primaryKey'] = !empty($entity['primaryKey']) ? $entity['primaryKey'] : 'id';
			$entity['elementName'] = !empty($entity['elementName']) ? $entity['elementName'] : $name . '_id';
			$entity['elementId'] = !empty($entity['elementId']) ? $entity['elementId'] : $formId . '-' . $entity['elementName'];
			$entity['prompt'] = !empty($entity['prompt']) ? $entity['prompt'] : '- Select -';
		}
		return $entities;
	}
	
	private function setChild($entities) {
		foreach($entities as $name => &$entity) {
			$entity['child'] = !empty($entity['childName']) ? $entities[$entity['childName']] : [];
		}
		return $entities;
	}
	
	private function getFormId() {
		$fullClassName = get_class($this->model);
		$className = basename($fullClassName);
		$formId = strtolower($className);
		return $formId;
	}
}
