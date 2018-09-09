<?php

namespace yii2lab\extension\encrypt\enums;

use yii2lab\extension\enum\base\BaseEnum;

/**
 * Class HashAlgoEnum
 * 
 * @package yii2lab\extension\encrypt\enums
 */
class HashAlgoEnum extends BaseEnum {

	const MD2 = 'md2';

	const MD4 = 'md4';

	const MD5 = 'md5';

	const SHA1 = 'sha1';

	const SHA224 = 'sha224';

	const SHA256 = 'sha256';

	const SHA384 = 'sha384';

	const SHA512 = 'sha512';

	const RIPEMD128 = 'ripemd128';

	const RIPEMD160 = 'ripemd160';

	const RIPEMD256 = 'ripemd256';

	const RIPEMD320 = 'ripemd320';

	const WHIRLPOOL = 'whirlpool';

	const TIGER128_3 = 'tiger128,3';

	const TIGER160_3 = 'tiger160,3';

	const TIGER192_3 = 'tiger192,3';

	const TIGER128_4 = 'tiger128,4';

	const TIGER160_4 = 'tiger160,4';

	const TIGER192_4 = 'tiger192,4';

	const SNEFRU = 'snefru';

	const SNEFRU256 = 'snefru256';

	const GOST = 'gost';

	const GOST_CRYPTO = 'gost-crypto';

	const ADLER32 = 'adler32';

	const CRC32 = 'crc32';

	const CRC32B = 'crc32b';

	const FNV132 = 'fnv132';

	const FNV1A32 = 'fnv1a32';

	const FNV164 = 'fnv164';

	const FNV1A64 = 'fnv1a64';

	const JOAAT = 'joaat';

	const HAVAL128_3 = 'haval128,3';

	const HAVAL160_3 = 'haval160,3';

	const HAVAL192_3 = 'haval192,3';

	const HAVAL224_3 = 'haval224,3';

	const HAVAL256_3 = 'haval256,3';

	const HAVAL128_4 = 'haval128,4';

	const HAVAL160_4 = 'haval160,4';

	const HAVAL192_4 = 'haval192,4';

	const HAVAL224_4 = 'haval224,4';

	const HAVAL256_4 = 'haval256,4';

	const HAVAL128_5 = 'haval128,5';

	const HAVAL160_5 = 'haval160,5';

	const HAVAL192_5 = 'haval192,5';

	const HAVAL224_5 = 'haval224,5';

	const HAVAL256_5 = 'haval256,5';

}

/*
$algos = [];
foreach (hash_algos() as $algo) {
    $algos[] = [
        'name' => $algo,
        'value' => $algo,
    ];
}
EnumGeneratorHelper::generate([
    'className' => '@yii2lab/extension/encrypt/enums/HashAlgoEnum',
    'const' => $algos,
]);
 */