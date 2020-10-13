<?php


namespace JavaReact\CQApi;

/**
 * 直冲接口
 * @package JavaReact\CQApi
 */
class CQOrder extends Client
{

    /**
     * 话费充值接口
     * @param string $order_no        商户提交的订单号，最长32位
     * @param string $recharge_number 手机号码
     * @param int    $price           充值面值,以分为单位
     * @param string $notify_url      橙券主动通知订单结果地址
     * @return CQApiResponse
     */
    public function telPay(string $order_no, string $recharge_number, int $price, string $notify_url = '')
    {
        $params = [
            'order_no'        => $order_no,
            'recharge_number' => $recharge_number,
            'price'           => $price,
            'notify_url'      => $notify_url,
        ];
        return $this->request("order/tel/pay", $params);
    }

    /**
     * 直充下单接口,开发者可通过该接口对橙券支持的所有直充产品进行充值,话费充值请使用telPay
     *
     * @param string $order_no          商户提交的订单号，最长32位（商户保证其唯一性）
     * @param string $recharge_number   充值账号
     * @param int    $product_id        产品编号（具体由橙券商务提供）
     * @param int    $amount            充值数量（加油卡，视频业务默认为1，其它业务按照实际情况传递）。数量范围1-99999,目前均为1笔
     * @param string $ip                充值ip（仅腾讯业务需要，根据实际情况进行传递）,传空会报错
     * @param string $oil_phone_account 加油卡充值时用户的手机号
     * @param string $notify_url        橙券主动通知订单结果地址
     * @return CQApiResponse
     */
    public function directCharge(string $order_no, string $recharge_number, int $product_id, int $amount = 1, string $ip = '', $oil_phone_account = '', string $notify_url = '')
    {
        $params = [
            'order_no'          => $order_no,
            'recharge_number'   => $recharge_number,
            'product_id'        => $product_id,
            'amount'            => $amount,
            'oil_phone_account' => $oil_phone_account,
            'notify_url'        => $notify_url,
            'version'           => '1.1.0',//目前固定
        ];
        if ($ip && filter_var($ip, FILTER_VALIDATE_IP)) {
            $params['ip'] = $ip;//传空或者格式不正确会报参数错误
        }
        if ($oil_phone_account) {
            $params['oil_phone_account'] = $oil_phone_account;
        }
        return $this->request("order/directCharge", $params);
    }

    /**
     * 直充订单查询
     * @param string $order_no 商户提交的订单号，最长32位（商户保证其唯一性）
     * @param string $version
     * @return CQApiResponse
     */
    public function orderGet(string $order_no, string $version = '')
    {
        $params = [
            'order_no' => $order_no,
            'version'  => $version,
        ];
        return $this->request("order/get", $params);
    }

}