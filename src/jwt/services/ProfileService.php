<?php

namespace yii2lab\extension\jwt\services;

use yii\web\NotFoundHttpException;
use yii2lab\domain\data\Query;
use yii2lab\extension\jwt\interfaces\services\ProfileInterface;
use yii2lab\domain\services\base\BaseActiveService;

/**
 * Class ProfileService
 * 
 * @package yii2lab\extension\jwt\services
 * 
 * @property-read \yii2lab\extension\jwt\Domain $domain
 * @property-read \yii2lab\extension\jwt\interfaces\repositories\ProfileInterface $repository
 */
class ProfileService extends BaseActiveService implements ProfileInterface {

    public function oneById($id, Query $query = null) {
        try {
            $profileEntity = $this->repository->oneById($id);
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException("Profile \"{$id}\" not defined!");
        }
        $profileEntity->validate();
        return $profileEntity;
    }

}
