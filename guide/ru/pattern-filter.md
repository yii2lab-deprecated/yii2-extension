Фильтр
===

Фильтр - это класс с произвольным набором атрибутов и методом `run`.

Когда выполняется цепочка фильтров, каждый фильтр принимает данные, обрабатывает и возвращает.

Затем эти данные попадают к следующему фильтру и т.д. по цепочке.

Метод фильтра `run` принимает данные в параметре и возвращает данные после обработки.

Класс реализует интерфейс `yii2lab\misc\interfaces\FilterInterface`.

Класс фильтра выглядит так:

```php
class CutSpaces implements FilterInterface {

	public $cutTabs = false;
	
	public function run($data) {
		...
		return $data;
	}
	
}
```

Вызвать один фильтр:

```php
$config = [
	'class' => CutSpaces::class,
	'cutTabs' => true,
];
$data = FilterHelper::run($config, $data);
```

Можно создать объект фильтра, для того, чтобы позже вызвать этот фильтр с заранее заданными параметрами:

```php
$config = [
	'class' => CutSpaces::class,
	'cutTabs' => true,
];
$cutSpaceFilter = FilterHelper::create($config);
```

Позже можно вызвать фильтр:

```php
$data = $cutSpaceFilter->run($data);
```

Выполнить цепочку фильтров:

```php
$filters = [
	...
	[
		'class' => CutSpaces::class,
		'cutTabs' => true,
	],
	...
];
$data = FilterHelper::runAll($filters, $data);
```
