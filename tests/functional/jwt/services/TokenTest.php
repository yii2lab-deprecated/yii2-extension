<?php

namespace tests\functional\jwt\services;

use yii\helpers\ArrayHelper;
use yii2lab\app\domain\helpers\EnvService;
use yii2lab\extension\jwt\entities\JwtEntity;
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

    public function testSign()
    {
        $userId = 1;
        $profileName = 'default';
        $jwtEntity = $this->forgeJwtEntity($userId);
        $jwtEntity->expire_at = 1536247466;
        \Dii::$domain->jwt->jwt->sign($jwtEntity, $profileName);
        $expected = DataHelper::loadForTest(self::PACKAGE, __METHOD__, $jwtEntity);
        $this->tester->assertRegExp('#^[a-zA-Z0-9-_\.]+$#', $jwtEntity->token);
    }

    public function testSignAndDecode()
    {
        $userId = 1;
        $profileName = 'default';
        $jwtEntity = $this->forgeJwtEntity($userId);
        \Dii::$domain->jwt->jwt->sign($jwtEntity, $profileName);
        $jwtEntityDecoded = \Dii::$domain->jwt->jwt->decode($jwtEntity->token);
        $this->tester->assertEquals($jwtEntity->subject['id'], $jwtEntityDecoded->subject['id']);
    }

    public function testSignAndDecodeEmptyToken()
    {
        $userId = 1;
        $profileName = 'default';
        $jwtEntity = $this->forgeJwtEntity($userId);
       try {
           $jwtEntityDecoded = \Dii::$domain->jwt->jwt->decode($jwtEntity->token);
           $this->tester->assertTrue(false);
        } catch (\UnexpectedValueException $e) {
           $this->tester->assertExceptionMessage('Wrong number of segments', $e);
        }
    }

    public function testSignAndDecodeBadToken()
    {
        $userId = 1;
        $profileName = 'default';
        $jwtEntity = $this->forgeJwtEntity($userId);
        try {
            $jwtEntityDecoded = \Dii::$domain->jwt->jwt->decode($jwtEntity->token);
            $this->tester->assertTrue(false);
        } catch (\UnexpectedValueException $e) {
            $this->tester->assertExceptionMessage('Wrong number of segments', $e);
        }
    }

    public function testSignAndDecodeRaw()
    {
        $userId = 1;
        $profileName = 'default';
        $jwtEntity = $this->forgeJwtEntity($userId);
        $jwtEntity->expire_at = 1536247466;
        \Dii::$domain->jwt->jwt->sign($jwtEntity, $profileName);
        $decoded = \Dii::$domain->jwt->jwt->decodeRaw($jwtEntity->token);

        $this->tester->assertEquals('JWT', $decoded->header->typ);
        $this->tester->assertEquals('HS256', $decoded->header->alg);
        $this->tester->assertRegExp('#[\w]{8}-[\w]{4}-[\w]{4}-[\w]{4}-[\w]{12}#', $decoded->header->kid);
        $this->tester->assertEquals('http://api.example.com/v1/auth', $decoded->payload->iss);
        $this->tester->assertEquals('http://api.example.com/v1/user/1', $decoded->payload->sub);
        $this->tester->assertEquals(['http://api.core.yii'], $decoded->payload->aud);
        $this->tester->assertEquals(1536247466, $decoded->payload->exp);
        $this->tester->assertNotEmpty($decoded->sig);
    }

    private function forgeJwtEntity($userId) {
        $jwtEntity = new JwtEntity();
        $jwtEntity->issuer_url = EnvService::getUrl(API, 'v1/auth');
        $jwtEntity->subject_url = EnvService::getUrl(API, 'v1/user/' . $userId);
        $jwtEntity->subject = [
            'id' => $userId,
        ];
        return $jwtEntity;
    }

}
