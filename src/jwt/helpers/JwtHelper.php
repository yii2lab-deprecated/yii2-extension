<?php

namespace yii2lab\extension\jwt\helpers;

use Firebase\JWT\JWT;
use yii2lab\extension\jwt\entities\ProfileEntity;

class JwtHelper
{

    private static function validateHeader($header, ProfileEntity $profileEntity) {
        $key = $profileEntity->key;
        if (empty($header->alg)) {
            throw new UnexpectedValueException('Empty algorithm');
        }
        if (empty(JWT::$supported_algs[$header->alg])) {
            throw new UnexpectedValueException('Algorithm not supported');
        }
        if (!in_array($header->alg, $profileEntity->allowed_algs)) {
            throw new UnexpectedValueException('Algorithm not allowed');
        }
        if (is_array($key) || $key instanceof \ArrayAccess) {
            if (isset($header->kid)) {
                if (!isset($key[$header->kid])) {
                    throw new UnexpectedValueException('"kid" invalid, unable to lookup correct key');
                }
                $key = $key[$header->kid];
            } else {
                throw new UnexpectedValueException('"kid" empty, unable to lookup correct key');
            }
        }
    }

    public static function decodeRaw($token, ProfileEntity $profileEntity) {
        $decodedObject = JwtHelper::tokenDecode($token);
        if (empty($profileEntity->key)) {
            throw new InvalidArgumentException('Key may not be empty');
        }
        self::validateHeader($decodedObject->header, $profileEntity);
        return $decodedObject;
    }

    public static function tokenDecode($jwt) {
        $tks = explode('.', $jwt);
        $result = new \stdClass();
        $result->header = self::tokenDecodeItem($tks[0]);
        $result->payload = self::tokenDecodeItem($tks[1]);
        $result->sig = JWT::urlsafeB64Decode($tks[2]);
        return $result;
    }

    private static function tokenDecodeItem($data) {
        $jsonCode = JWT::urlsafeB64Decode($data);
        $object = JWT::jsonDecode($jsonCode);
        if (null === $object) {
            throw new UnexpectedValueException('Invalid encoding');
        }
        return $object;
    }

}
