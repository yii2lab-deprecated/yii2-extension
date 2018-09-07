<?php

namespace yii2lab\extension\jwt\repositories\env;

use yii2lab\app\domain\helpers\EnvService;
use yii2lab\domain\data\Query;
use yii2lab\extension\arrayTools\traits\ArrayReadTrait;
use yii2lab\extension\jwt\interfaces\repositories\ProfileInterface;
use yii2lab\domain\repositories\BaseRepository;

/**
 * Class ProfileRepository
 * 
 * @package yii2lab\extension\jwt\repositories\memory
 * 
 * @property-read \yii2lab\extension\jwt\Domain $domain
 */
class ProfileRepository extends BaseRepository implements ProfileInterface {

    use ArrayReadTrait;

	//protected $schemaClass = true;
    protected $primaryKey = 'id';

    protected function getCollection()
    {
        $envProfiles = EnvService::get('jwt.profiles', []);
        $profiles = [];
        foreach ($envProfiles as $name => $config) {
            $config['id'] = $name;
            $profiles[$name] = $config;
        }
        return $profiles;
    }

}
