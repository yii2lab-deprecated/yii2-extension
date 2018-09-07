<?php

namespace yii2lab\extension\jwt\repositories\jwt;

use yii\base\Object;
use yii\helpers\ArrayHelper;
use yii2lab\extension\jwt\entities\JwtEntity;
use yii2lab\extension\jwt\entities\ProfileEntity;
use yii2lab\extension\jwt\helpers\JwtHelper;
use yii2lab\extension\jwt\interfaces\repositories\JwtInterface;
use yii2lab\domain\repositories\BaseRepository;
use Firebase\JWT\JWT;
use yii2lab\helpers\StringHelper;

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
        $keyId = StringHelper::genUuid();
        $jwtEntity->token = JWT::encode($data, $profileEntity->key, $profileEntity->default_alg, $keyId);
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

    public function decodeRaw($token, ProfileEntity $profileEntity) {
        $key = $profileEntity->key;
        $decodedObject = JwtHelper::tokenDecode($token);
        if (empty($key)) {
            throw new InvalidArgumentException('Key may not be empty');
        }
        if (empty($decodedObject->header->alg)) {
            throw new UnexpectedValueException('Empty algorithm');
        }
        if (empty(JWT::$supported_algs[$decodedObject->header->alg])) {
            throw new UnexpectedValueException('Algorithm not supported');
        }
        if (!in_array($decodedObject->header->alg, $profileEntity->allowed_algs)) {
            throw new UnexpectedValueException('Algorithm not allowed');
        }
        if (is_array($key) || $key instanceof \ArrayAccess) {
            if (isset($decodedObject->header->kid)) {
                if (!isset($key[$decodedObject->header->kid])) {
                    throw new UnexpectedValueException('"kid" invalid, unable to lookup correct key');
                }
                $key = $key[$decodedObject->header->kid];
            } else {
                throw new UnexpectedValueException('"kid" empty, unable to lookup correct key');
            }
        }
        return $decodedObject;
    }

    private function entityToToken(JwtEntity $jwtEntity) {
        $data = $jwtEntity->toArray();
        $data = array_filter($data, function ($value) {return $value !== null;});
        $data = $this->alias->encode($data);
        return $data;
    }

}
