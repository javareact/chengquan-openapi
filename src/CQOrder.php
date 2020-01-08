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
     * @return CQApiResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function telPay()
    {
        $params = [
        ];
        return $this->request("order/tel/pay", $params);
    }

    /**
     * 流量充值接口
     * @return CQApiResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function gprsPay()
    {
        $params = [
        ];
        return $this->request("order/gprs/pay", $params);
    }

    /**
     * 加油卡充值接口
     * @return CQApiResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function oilPay()
    {
        $params = [
        ];
        return $this->request("order/oil/pay", $params);
    }

    /**
     * 腾讯业务接口
     *
     * @return CQApiResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function qqPay()
    {
        $params = [
        ];
        return $this->request("order/qq/pay", $params);
    }

    /**
     * 视频充值接口
     * @return CQApiResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function videoPay()
    {
        $params = [
        ];
        return $this->request("order/video/pay", $params);
    }

    /**
     * 直充订单查询
     * @return CQApiResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function orderGet()
    {
        $params = [
        ];
        return $this->request("order/get", $params);
    }

}