BaseCoreRepository
===

## Основное

Наследует класс [BaseRestRepository](https://github.com/yii2lab/yii2-rest/blob/master/guide/ru/repository-base-rest.md).

## Поля

* `version` - версия API (число)
* `point` - относительный URL

## Пример

```php
use yii2lab\core\domain\repositories\base\BaseCoreRepository;
use yii2lab\misc\enums\HttpMethodEnum;
use yii2lab\rest\domain\entities\RequestEntity;
use yii2module\account\domain\v2\entities\LoginEntity;

class AuthRepository extends BaseCoreRepository {

	public $version = 1;
	public $point = 'auth';
	
	public function login($login, $password) {
		$responseEntity = $this->post(null, [
			'login' => $login,
			'password' => $password,
		]);
		return $this->forgeEntity($responseEntity->data, LoginEntity::class);
	}
	
	public function loginAlt($login, $password) {
		$requestEntity = new RequestEntity;
		$requestEntity->method = HttpMethodEnum::POST;
		$requestEntity->uri = null;
		$requestEntity->data = [
			'login' => $login,
			'password' => $password,
		];
		$responseEntity =  $this->sendRequest($requestEntity);
		return $this->forgeEntity($responseEntity->data, LoginEntity::class);
	}
	
}
```

Тут описаны два метода со идентичным функционалом, но с разными методами реализации.

Домен берется из `env('servers.core.domain')`.

В итоге базовый URL репозитория будет таким: `http://api.example.com/v1/auth`.