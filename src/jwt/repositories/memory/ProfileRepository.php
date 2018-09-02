<?php

namespace yii2lab\extension\jwt\repositories\memory;

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
    protected $primaryKey = 'name';
    private $profiles = null;

	protected function getCollection()
    {
        $profiles = [];
        foreach ($this->profiles as $name => $config) {
            $config['name'] = $name;
            $profiles[$name] = $config;
        }
        return $profiles;
    }

    public function setProfiles($value) {
        $this->profiles = $value;
    }

}
