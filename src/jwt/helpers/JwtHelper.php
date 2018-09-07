<?php

namespace yii2lab\extension\jwt\helpers;

use Firebase\JWT\JWT;

class JwtHelper
{

    public function tokenDecode($jwt) {
        $tks = explode('.', $jwt);
        $result = new \stdClass();
        $result->header = self::tokenDecodeItem($tks[0]);
        $result->payload = self::tokenDecodeItem($tks[1]);
        $result->sig = JWT::urlsafeB64Decode($tks[2]);
        return $result;
    }

    private function tokenDecodeItem($data) {
        $jsonCode = JWT::urlsafeB64Decode($data);
        $object = JWT::jsonDecode($jsonCode);
        if (null === $object) {
            throw new UnexpectedValueException('Invalid encoding');
        }
        return $object;
    }

}
