<?php

namespace tests\functional\jwt\services;

use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii2lab\app\domain\helpers\EnvService;
use yii2lab\extension\jwt\entities\TokenEntity;
use yii2lab\extension\jwt\entities\TokenEntity;
use yii2lab\extension\enum\enums\TimeEnum;
use yii2lab\test\helpers\DataHelper;
use yii2lab\test\helpers\TestHelper;
use yii2lab\test\Test\Unit;
use Yii;
use tests\functional\v1\enums\LoginEnum;
use yii\web\ForbiddenHttpException;
use yii2module\account\domain\v2\helpers\TestAuthHelper;

class TokenTest extends Unit
{

    const PACKAGE = 'yii2lab/yii2-extension';

    public function testNotFoundProfile()
    {
        $userId = 1;
        $profileName = 'default111111111111111';
        $tokenEntity = $this->forgeTokenEntity($userId);
        $tokenEntity->expire_at = 1536247466;
        try {
            \Dii::$domain->jwt->token->sign($tokenEntity, $profileName, '6c6979ec-9575-4794-9303-0d2b851edb02');
            $this->tester->assertTrue(false);
        } catch (NotFoundHttpException $e) {
            $this->tester->assertExceptionMessage('Profile "default111111111111111" not defined!', $e);
        }
    }

    public function testSign()
    {
        $userId = 1;
        $profileName = 'default';
        $tokenEntity = $this->forgeTokenEntity($userId);
        $tokenEntity->expire_at = 1536247466;
        \Dii::$domain->jwt->token->sign($tokenEntity, $profileName, '6c6979ec-9575-4794-9303-0d2b851edb02');
        $expected = DataHelper::loadForTest(self::PACKAGE, __METHOD__, $tokenEntity->toArray());
        $this->tester->assertEquals($expected, $tokenEntity->toArray());
        $this->tester->assertRegExp('#^[a-zA-Z0-9-_\.]+$#', $tokenEntity->token);
    }

    public function testExpired()
    {
        $userId = 1;
        $profileName = 'default';
        $tokenEntity = $this->forgeTokenEntity($userId);
        $tokenEntity->expire_at = TIMESTAMP - TimeEnum::SECOND_PER_HOUR;
        \Dii::$domain->jwt->token->sign($tokenEntity, $profileName, '6c6979ec-9575-4794-9303-0d2b851edb02');
        try {
            $tokenEntityDecoded = \Dii::$domain->jwt->token->decode($tokenEntity->token);
            $this->tester->assertTrue(false);
        } catch (ExpiredException $e) {
            $this->tester->assertExceptionMessage('Expired token', $e);
        }
    }

    public function testBegin()
    {
        $userId = 1;
        $profileName = 'default';
        $tokenEntity = $this->forgeTokenEntity($userId);
        $tokenEntity->begin_at = TIMESTAMP + TimeEnum::SECOND_PER_HOUR;
        \Dii::$domain->jwt->token->sign($tokenEntity, $profileName, '6c6979ec-9575-4794-9303-0d2b851edb02');
        try {
            $tokenEntityDecoded = \Dii::$domain->jwt->token->decode($tokenEntity->token);
            $this->tester->assertTrue(false);
        } catch (BeforeValidException $e) {
            $this->tester->assertExceptionMessageRegexp('#Cannot handle token prior to#', $e);
        }
    }

    public function testSignAndDecode()
    {
        $userId = 1;
        $profileName = 'default';
        $tokenEntity = $this->forgeTokenEntity($userId);
        \Dii::$domain->jwt->token->sign($tokenEntity, $profileName);
        $tokenEntityDecoded = \Dii::$domain->jwt->token->decode($tokenEntity->token);
        $this->tester->assertEquals($tokenEntity->subject['id'], $tokenEntityDecoded->subject['id']);
    }

    public function testSignAndDecodeEmptyToken()
    {
        $userId = 1;
        $profileName = 'default';
        $tokenEntity = $this->forgeTokenEntity($userId);
       try {
           $tokenEntityDecoded = \Dii::$domain->jwt->token->decode($tokenEntity->token);
           $this->tester->assertTrue(false);
        } catch (\UnexpectedValueException $e) {
           $this->tester->assertExceptionMessage('Wrong number of segments', $e);
        }
    }

    public function testSignAndDecodeBadToken()
    {
        $userId = 1;
        $profileName = 'default';
        $tokenEntity = $this->forgeTokenEntity($userId);
        try {
            $tokenEntityDecoded = \Dii::$domain->jwt->token->decode($tokenEntity->token);
            $this->tester->assertTrue(false);
        } catch (\UnexpectedValueException $e) {
            $this->tester->assertExceptionMessage('Wrong number of segments', $e);
        }
    }

    public function testSignAndDecodeRaw()
    {
        $userId = 1;
        $profileName = 'default';
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImtpZCI6IjZjNjk3OWVjLTk1NzUtNDc5NC05MzAzLTBkMmI4NTFlZGIwMiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGkuZXhhbXBsZS5jb21cL3YxXC9hdXRoIiwic3ViamVjdCI6eyJpZCI6MX0sInN1YiI6Imh0dHA6XC9cL2FwaS5leGFtcGxlLmNvbVwvdjFcL3VzZXJcLzEiLCJhdWQiOlsiaHR0cDpcL1wvYXBpLmNvcmUueWlpIl0sImV4cCI6MTUzNjI0NzQ2Nn0.XjAxVetPxtldVYLQwkVmKNwbjlatLD5yo_PXfHcwEHo';
        $decoded = \Dii::$domain->jwt->token->decodeRaw($token);
        $this->tester->assertRegExp('#[\w]{8}-[\w]{4}-[\w]{4}-[\w]{4}-[\w]{12}#', $decoded->header->kid);
        $this->tester->assertNotEmpty($decoded->sig);
        $this->tester->assertArraySubset([
            'sig' => base64_decode('XjAxVetPxtldVYLQwkVmKNwbjlatLD5yo/PXfHcwEHo='),
            'header' => [
                'typ' => 'JWT',
                'alg' => 'HS256',
                'kid' => '6c6979ec-9575-4794-9303-0d2b851edb02',
            ],
            'payload' => [
                'iss' => 'http://api.example.com/v1/auth',
                'sub' => 'http://api.example.com/v1/user/1',
                'aud' => [
                    'http://api.core.yii',
                ],
                'exp' => 1536247466,
                'subject' => [
                    'id' => $userId,
                ],
            ],
        ], ArrayHelper::toArray($decoded));
    }

    private function forgeTokenEntity($userId) {
        $tokenEntity = new TokenEntity();
        $tokenEntity->issuer_url = EnvService::getUrl(API, 'v1/auth');
        $tokenEntity->subject_url = EnvService::getUrl(API, 'v1/user/' . $userId);
        $tokenEntity->subject = [
            'id' => $userId,
        ];
        return $tokenEntity;
    }

}
