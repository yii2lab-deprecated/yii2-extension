<?php

namespace yii2lab\extension\store\interfaces;

interface DriverInterface
{

    public function decode($content);
    public function encode($data);

}