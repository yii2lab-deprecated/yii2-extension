Команда
===

Команда - это класс с произвольным набором атрибутов и методом `run`.

Команда может быть полезна в тех случаях, когда:

* необходимо абстрагироваться от реализации
* заранее не известен код, который нужно выполнить
* нужно выполнить цепочку команд
* необходимо задавать исполнителей и их параметры в кофиге

Класс реализует интерфейс `yii2lab\misc\interfaces\CommandInterface`.

Класс команды выглядит так:

```php
class Email implements CommandInterface {

	public $address;
	public $subject;
	public $message;
	
	public function run() {
		...
	}
	
}
```

Вызвать эту команду можно так:

```php
$config = [
	'class' => Email::class,
	'address' => 'example@example.com',
	'subject' => 'The email',
	'message' => 'The content',
];
CommandHelper::run($config);
```

или так:

```php
$config = [
	'address' => 'example@example.com',
	'subject' => 'The email',
	'message' => 'The content',
];
CommandHelper::run($config, Email::class);
```

Можно создать объект команды, для того, чтобы позже выполнить эту команду с заранее заданными параметрами:

```php
$config = [
	'class' => Email::class,
	'address' => 'example@example.com',
	'subject' => 'The email',
	'message' => 'The content',
];
$emailCommand = CommandHelper::create($config);
```

Позже можно выполнить команду:

```php
$emailCommand->run();
```

Выполнить цепочку команд можно так:

```php
$all = [
	...
	[
		'class' => Email::class,
		'address' => 'example@example.com',
		'subject' => 'The email',
		'message' => 'The content',
	],
	...
];
CommandHelper::runAll($all);
```
