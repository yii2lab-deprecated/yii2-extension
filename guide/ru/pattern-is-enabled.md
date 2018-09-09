Выключение фильтров и команд
===

Можно задать параметр `isEnabled` чтобы отключить выполнение фильтра.

Например:

```php
[
	'class' => LoadDomainConfig::class,
	'app' => COMMON,
	'name' => 'install',
	'withLocal' => false,
	'isEnabled' => APP == CONSOLE,
],
```

Можно написать метод `isEnabled`, который будет возвращать `true` или `false`.

Например:

```php
public function isEnabled() {
	return APP == CONSOLE;
}
```
