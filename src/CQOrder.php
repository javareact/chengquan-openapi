<?php


namespace JavaReact\CQApi;

/**
 * Class CQOrder 直冲接口
 * @package JavaReact\CQApi
 */
class CQOrder extends Client
{

    /**
     * 话费充值接口
     * @param string $order_no 商户提交的订单号，最长32位
     * @param string $recharge_number 手机号码
     * @param int $price 充值面值,以分为单位
     * @param string $notify_url 橙券主动通知订单结果地址
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
     * 流量充值接口
     * @param string $order_no 商户提交的订单号，最长32位（商户保证其唯一性）
     * @param string $recharge_number 手机号码
     * @param int $gprs 充值流量值，单位：MB
     * @param string $validity_unit 流量有效期单位，DAY表示天，MONTH表示月
     * @param int $validity_num 流量有效期数量，数量(天/月)
     * @param string $notify_url 橙券主动通知订单结果地址
     * @return CQApiResponse
     */
    public function gprsPay(string $order_no, string $recharge_number, int $gprs, string $validity_unit, int $validity_num, string $notify_url = '')
    {
        $params = [
            'order_no'        => $order_no,
            'recharge_number' => $recharge_number,
            'gprs'            => $gprs,
            'validity_unit'   => $validity_unit,
            'validity_num'    => $validity_num,
            'notify_url'      => $notify_url,
        ];
        return $this->request("order/gprs/pay", $params);
    }

    /**
     * 加油卡充值接口
     * @param string $order_no 商户提交的订单号，最长32位（商户保证其唯一性）
     * @param string $recharge_number 加油卡卡号，中石化：19位，中石油：16位
     * @param int $price 充值金额，以分为单位
     * @param string $notify_url 橙券主动通知订单结果地址
     * @return CQApiResponse
     */
    public function oilPay(string $order_no, string $recharge_number, int $price, string $notify_url = '')
    {
        $params = [
            'order_no'        => $order_no,
            'recharge_number' => $recharge_number,
            'price'           => $price,
            'notify_url'      => $notify_url,
        ];
        return $this->request("order/oil/pay", $params);
    }

    /**
     * 腾讯业务接口
     *
     * @param string $order_no 商户提交的订单号，最长32位（商户保证其唯一性）
     * @param string $recharge_number QQ号码
     * @param int $amount 充值数量(正整数)
     * @param int $product_id 产品编号（具体由橙券商务提供）
     * @param string $notify_url 橙券主动通知订单结果地址
     * @return CQApiResponse
     */
    public function qqPay(string $order_no, string $recharge_number, int $amount, int $product_id, string $notify_url = '')
    {
        $params = [
            'order_no'        => $order_no,
            'recharge_number' => $recharge_number,
            'amount'          => $amount,
            'product_id'      => $product_id,
            'notify_url'      => $notify_url,
        ];
        return $this->request("order/qq/pay", $params);
    }

    /**
     * 视频充值接口
     * @param string $order_no 商户提交的订单号，最长32位（商户保证其唯一性）
     * @param string $recharge_number 账号
     * @param int $product_id 产品编号（具体由橙券商务提供）
     * @param string $notify_url 橙券主动通知订单结果地址
     * @return CQApiResponse
     */
    public function videoPay(string $order_no, string $recharge_number, int $product_id, string $notify_url = '')
    {
        $params = [
            'order_no'        => $order_no,
            'recharge_number' => $recharge_number,
            'product_id'      => $product_id,
            'notify_url'      => $notify_url,
        ];
        return $this->request("order/video/pay", $params);
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