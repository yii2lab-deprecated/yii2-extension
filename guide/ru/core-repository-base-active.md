BaseActiveCoreRepository
===

## Основное

Наследует класс [BaseCoreRepository](https://github.com/yii2lab/yii2-core/blob/master/guide/ru/repository-base-core.md).

Обеспечивает стандартный интерфейс `CrudInterface`.

То есть обладает полным набором методов для обеспечения CRUD.

## Пример

```php
use yii2lab\core\domain\repositories\base\BaseActiveCoreRepository;

class CityRepository extends BaseActiveCoreRepository {

	public $version = 1;
	public $point = 'city';
	
}
```

Используем в клиентском коде как обычно:

```php
$query = Query::forge();
$query->page(3);
$query->with('country');
$responseEntity = Yii::$app->geo->repositories->city->all($query);
```
