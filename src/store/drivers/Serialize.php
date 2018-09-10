<?php

namespace yii2lab\extension\store\drivers;

use yii2lab\extension\store\interfaces\DriverInterface;
use yii2mod\helpers\ArrayHelper;

class Serialize implements DriverInterface
{

    public function decode($content) {
        $data = unserialize($content);
        //$data = ArrayHelper::toArray($data);
        return $data;
    }

    public function encode($data) {
        $content = serialize($data);
        return $content;
    }

}