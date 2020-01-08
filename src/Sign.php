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
     * @param array $parameters
     * @param string $secret
     * @return string
     */
    public static function getSign(array $parameters, string $secret): string
    {
        //签名步骤一：排序
        ksort($parameters, SORT_STRING);
        $tmpArr = [];
        //签名步骤二：去除空值
        foreach ($parameters as $key => $item) {
            if ($item === '' || $item === null) {
                continue;
            }
            $tmpArr[] = $key . '=' . $item;
        }
        //签名步骤三：转化为字符串
        $string = implode('&', $tmpArr);
        //签名步骤四：在string后加入key
        $string = $string . '&key=' . $secret;
        //签名步骤五：MD5加密
        return strtoupper(md5($string));
    }
}