<?php

declare(strict_types=1);

namespace JavaReact\CQApi;

/**
 * 橙券签名算法
 * Class Sign
 * @package JavaReact\CQApi
 */
class Sign
{
    /**
     * @param array $Parameters
     * @param string $secret
     * @return string
     */
    static public function getSign(array $Parameters, string $secret): string
    {
        //签名步骤一：把字典json序列化
        $json = json_encode($Parameters, 320);
        //签名步骤二：转化为数组
        $jsonArr = self::mb_str_split($json);
        //签名步骤三：排序
        sort($jsonArr);
        //签名步骤四：转化为字符串
        $string = implode('', $jsonArr);
        //签名步骤五：在string后加入secret
        $string = $string . $secret;
        //签名步骤六：MD5加密
        $result = strtolower(md5($string));
        return $result;
    }

    /**
     * @param string $str
     * @return array
     */
    static public function mb_str_split(string $str): array
    {
        return preg_split('/(?<!^)(?!$)/u', $str);
    }
}