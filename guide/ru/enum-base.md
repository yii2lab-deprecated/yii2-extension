Основы
===

Классы Enum предназначены для хранения перечислений и удобного использования в коде.

## Пример объявления

```php
class HttpEnum extends BaseEnum {
	
	const METHOD_GET = 'GET';
	const METHOD_POST = 'POST';
	const METHOD_PUT = 'PUT';
	const METHOD_DELETE = 'DELETE';
	
	const STATUS_OK = 200;
	const STATUS_SERVER_ERROR = 500;

}
```

## Пример использования

```php
$method = HttpEnum::METHOD_GET;
```

или

```php
$value = HttpEnum::value('GET', 'method');
```

### Префикс

Если передать в первый параметр значение префикса, то получим список значений констант, которые имеют указанный префикс:

```php
$methodList = HttpEnum::values('method');
$statusList = HttpEnum::values('status');
```

Префикс работает во всех методах.

### Получение значений

```php
$values = HttpEnum::values();
```

### Получение имен констант

```php
$names = HttpEnum::keys();
```

### Получение пар ключ-значение

```php
$all = HttpEnum::all();
```

### Валидация

```php
$isValid = HttpEnum::isValid($value, 'method');
```

Параметры:

* значение
* значение по умолчанию
* префикс
