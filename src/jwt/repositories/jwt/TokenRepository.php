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

    public function sign(TokenEntity $tokenEntity, ProfileEntity $profileEntity, $keyId = null, $head = null) {
        if($profileEntity->audience) {
            $tokenEntity->audience = ArrayHelper::merge($tokenEntity->audience, $profileEntity->audience);
        }
        if(!$tokenEntity->expire_at && $profileEntity->life_time) {
            $tokenEntity->expire_at = TIMESTAMP + $profileEntity->life_time;
        }
        $data = $this->entityToToken($tokenEntity);
	    $key = $this->extractKey($profileEntity->key, 'private');
        $tokenEntity->token = JWT::encode($data, $key, $profileEntity->default_alg, $keyId, $head);
    }

    public function encode(TokenEntity $tokenEntity, ProfileEntity $profileEntity) {
        $this->sign($tokenEntity, $profileEntity);
        return $tokenEntity->token;
    }

    public function decode($token, ProfileEntity $profileEntity) {
    	$key = $this->extractKey($profileEntity->key, 'public');
        $decoded = JWT::decode($token, $key, $profileEntity->allowed_algs);
        $tokenEntity = $this->forgeEntity($decoded);
        return $tokenEntity;
    }

    public function decodeRaw($token, ProfileEntity $profileEntity) {
        return JwtHelper::decodeRaw($token, $profileEntity);
    }
	
	private function extractKey($key, $name) {
		if(is_array($key)) {
			$key = $key[$name];
		}
		return $key;
	}
    
    private function entityToToken(TokenEntity $tokenEntity) {
        $data = $tokenEntity->toArray();
        $data = array_filter($data, function ($value) {return $value !== null;});
        $data = $this->alias->encode($data);
        return $data;
    }

}
