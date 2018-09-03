<?php

namespace yii2lab\extension\jwt\services;

use yii\base\InvalidConfigException;
use yii\web\NotFoundHttpException;
use yii2lab\app\domain\helpers\EnvService;
use yii2lab\domain\data\Query;
use yii2lab\extension\jwt\entities\ProfileEntity;
use yii2lab\extension\jwt\interfaces\services\JwtInterface;
use yii2lab\domain\services\base\BaseService;
use yii2lab\domain\Alias;
use yii2lab\helpers\yii\ArrayHelper;
use yii2lab\extension\jwt\entities\JwtEntity;

/**
 * Class JwtService
 * 
 * @package yii2lab\extension\jwt\services
 * 
 * @property-read \yii2lab\extension\jwt\Domain $domain
 * @property-read \yii2lab\extension\jwt\interfaces\repositories\JwtInterface $repository
 */
class JwtService extends BaseService implements JwtInterface {

    const DEFAULT_PROFILE = 'default';

    private function getProfile($name) {
        try {
            $profileEntity = $this->domain->repositories->profile->oneById($name);
        } catch (NotFoundHttpException $e) {
            throw new InvalidConfigException("Profile \"{$name}\" not defined!");
        }
        $profileEntity->validate();
        return $profileEntity;
    }

    public function sign(JwtEntity $jwtEntity, $profileName = self::DEFAULT_PROFILE) {
        $profileEntity = $this->getProfile($profileName);
        $this->repository->sign($jwtEntity, $profileEntity);
        return $jwtEntity;
    }

    public function decode($token, $profileName = self::DEFAULT_PROFILE) {
        $profileEntity = $this->getProfile($profileName);
        $jwtEntity = $this->repository->decode($token, $profileEntity);
        $jwtEntity->token = $token;
        return $jwtEntity;
    }

}

/**
 * Example
 *
 *
 * 'jwt' => [
'profiles' => [
'default' => [
'key' => 'qwerty123',
'life_time' => \yii2lab\misc\enums\TimeEnum::SECOND_PER_MINUTE * 20,
'allowed_algs' => ['HS256', 'SHA512', 'HS384'],
'default_alg' => 'HS256',
'audience' => ["http://api.core.yii"],
],
],
],
 *
 *
 * $jwtEntity = new JwtEntity();
//$jwtEntity->audience = ["http://api.wooppay.yii"];
$jwtEntity->subject_id = \Dii::$domain->account->auth->identity->id;
//$jwtEntity->subject_url = "http://api.core.yii/v1/user/" . $jwtEntity->subject_id;

\Dii::$domain->account->jwt->sign($jwtEntity);
$jwt = $jwtEntity->token;
$decodedEntity = \Dii::$domain->account->jwt->decode($jwt);

if($decodedEntity->toArray() != $jwtEntity->toArray()) {
prr('Not equaled!',1,1);
}
prr($jwtEntity,1,1);
 *
 */