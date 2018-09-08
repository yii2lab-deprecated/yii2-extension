<?php

namespace yii2lab\extension\jwt\repositories\jwt;

use yii2lab\extension\jwt\interfaces\repositories\TokenInterface;
use yii2lab\domain\repositories\BaseRepository;
use yii\helpers\ArrayHelper;
use yii2lab\extension\jwt\entities\TokenEntity;
use yii2lab\extension\jwt\entities\ProfileEntity;
use yii2lab\extension\jwt\helpers\JwtHelper;
use Firebase\JWT\JWT;

/**
 * Class TokenRepository
 * 
 * @package yii2lab\extension\jwt\repositories\jwt
 * 
 * @property-read \yii2lab\extension\jwt\Domain $domain
 */
class TokenRepository extends BaseRepository implements TokenInterface {

    public function fieldAlias() {
        return [
            'issuer_url' => 'iss',
            'subject_url' => 'sub',
            'audience' => 'aud',
            'expire_at' => 'exp',
            'begin_at' => 'nbf',
        ];
    }

    public function sign(TokenEntity $jwtEntity, ProfileEntity $profileEntity, $keyId = null, $head = null) {
        if($profileEntity->audience) {
            $jwtEntity->audience = ArrayHelper::merge($jwtEntity->audience, $profileEntity->audience);
        }
        if(!$jwtEntity->expire_at && $profileEntity->life_time) {
            $jwtEntity->expire_at = TIMESTAMP + $profileEntity->life_time;
        }
        $data = $this->entityToToken($jwtEntity);
        $jwtEntity->token = JWT::encode($data, $profileEntity->key, $profileEntity->default_alg, $keyId, $head);
    }

    public function encode(TokenEntity $jwtEntity, ProfileEntity $profileEntity) {
        $this->sign($jwtEntity, $profileEntity);
        return $jwtEntity->token;
    }

    public function decode($token, ProfileEntity $profileEntity) {
        $decoded = JWT::decode($token, $profileEntity->key, $profileEntity->allowed_algs);
        $jwtEntity = $this->forgeEntity($decoded);
        return $jwtEntity;
    }

    public function decodeRaw($token, ProfileEntity $profileEntity) {
        return JwtHelper::decodeRaw($token, $profileEntity);
    }

    private function entityToToken(TokenEntity $jwtEntity) {
        $data = $jwtEntity->toArray();
        $data = array_filter($data, function ($value) {return $value !== null;});
        $data = $this->alias->encode($data);
        return $data;
    }

}
