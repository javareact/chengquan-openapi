<?php

namespace JavaReact\CQApi;

/**
 * Class CQCoupon 卡券接口
 * @package JavaReact\CQApi
 */
class CQCoupon extends Client
{

    /**
     * 商户购买卡劵接口
     *
     * @return CQApiResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function orderPay()
    {
        $params = [
        ];
        return $this->request("coupon/order/pay", $params);
    }

    /**
     * 商户卡券订单查询接口
     * @return CQApiResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function orderQuery()
    {
        $params = [
        ];
        return $this->request("coupon/order/pay", $params);
    }

    /**
     * 查询卡券品牌接口
     * @return CQApiResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function typeList()
    {
        $params = [
        ];
        return $this->request("coupon/type/list", $params);
    }

    /**
     *
     * @return CQApiResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function typeGoodsList()
    {
        $params = [
        ];
        return $this->request("coupon/type/goods/list", $params);
    }

    /**
     * 查询卡券产品库存接口
     */
    public function goodsStock()
    {
        $params = [
        ];
        return $this->request("coupon/goods/stock", $params);
    }

    /**
     * 商户查询卡券产品使用须知接口
     * @return CQApiResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function goodsNotes()
    {
        $params = [
        ];
        return $this->request("coupon/goods/notes", $params);
    }

}