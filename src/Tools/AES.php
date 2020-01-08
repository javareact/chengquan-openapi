<?php

namespace JavaReact\CQApi\Tools;

/**
 * Class AES
 * @package JavaReact\CQApi\Tools
 */
class AES
{
    /**
     * 加密
     * @param string $string 要加密的字符
     * @param string $key key16位
     * @param string $iv iv16位
     * @param string $method 加密算法
     * @return string
     */
    public static function encrypt($string, $key, $iv = '', $method = 'aes-128-cbc')
    {
        $string    = trim($string);
        $encrypted = openssl_encrypt($string, $method, $key, 1, $iv);
        $encrypted = base64_encode($encrypted);
        return $encrypted;
    }

    /**
     * 解密
     * @param string $string 要解密的字符
     * @param string $key key16位
     * @param string $iv iv16位
     * @param string $method 加密算法
     * @return bool|string
     */
    public static function decrypt($string, $key, $iv = '', $method = 'aes-128-cbc')
    {
        $decrypted = base64_decode($string);
        $decrypted = openssl_decrypt($decrypted, $method, $key, 1, $iv);
        $decrypted = trim($decrypted);
        return $decrypted;
    }
}