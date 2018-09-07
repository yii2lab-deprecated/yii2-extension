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
        \Dii::$domain->jwt->jwt->sign($jwtEntity, $profileName, '6c6979ec-9575-4794-9303-0d2b851edb02');
        $expected = DataHelper::loadForTest(self::PACKAGE, __METHOD__, $jwtEntity->toArray());
        $this->tester->assertEquals($expected, $jwtEntity->toArray());
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

        $this->tester->assertRegExp('#[\w]{8}-[\w]{4}-[\w]{4}-[\w]{4}-[\w]{12}#', $decoded->header->kid);
        $this->tester->assertNotEmpty($decoded->sig);
        $this->tester->assertArraySubset([

            'header' => [
                'typ' => 'JWT',
                'alg' => 'HS256',
                //'kid' => '6c6979ec-9575-4794-9303-0d2b851edb02',
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
