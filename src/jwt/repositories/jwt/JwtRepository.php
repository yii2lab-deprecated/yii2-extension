<?php

namespace yii2lab\extension\jwt\repositories\jwt;

use yii\helpers\ArrayHelper;
use yii2lab\extension\jwt\entities\JwtEntity;
use yii2lab\extension\jwt\entities\ProfileEntity;
use yii2lab\extension\jwt\interfaces\repositories\JwtInterface;
use yii2lab\domain\repositories\BaseRepository;
use Firebase\JWT\JWT;

/**
 * Class JwtRepository
 * 
 * @package yii2lab\extension\jwt\repositories\jwt
 * 
 * @property-read \yii2lab\extension\jwt\Domain $domain
 */
class JwtRepository extends BaseRepository implements JwtInterface {

    public function fieldAlias() {
        return [
            'issuer_url' => 'iss',
            'subject_url' => 'sub',
            'audience' => 'aud',
            'expire_at' => 'exp',
            'begin_at' => 'nbf',
        ];
    }

    public function sign(JwtEntity $jwtEntity, ProfileEntity $profileEntity) {

        if($profileEntity->audience) {
            $jwtEntity->audience = ArrayHelper::merge($jwtEntity->audience, $profileEntity->audience);
        }
        if(!$jwtEntity->expire_at && $profileEntity->life_time) {
            $jwtEntity->expire_at = TIMESTAMP + $profileEntity->life_time;
        }

        $data = $this->entityToToken($jwtEntity);
        $jwtEntity->token = JWT::encode($data, $profileEntity->key);
    }

    public function encode(JwtEntity $jwtEntity, ProfileEntity $profileEntity) {
        $this->sign($jwtEntity, $profileEntity);
        return $jwtEntity->token;
    }

    public function decode($token, ProfileEntity $profileEntity) {
        $decoded = JWT::decode($token, $profileEntity->key, $profileEntity->allowed_algs);
        $jwtEntity = $this->forgeEntity($decoded);
        return $jwtEntity;
    }

    private function entityToToken(JwtEntity $jwtEntity) {
        $data = $jwtEntity->toArray();
        $data = array_filter($data, function ($value) {return $value !== null;});
        $data = $this->alias->encode($data);
        return $data;
    }

}
