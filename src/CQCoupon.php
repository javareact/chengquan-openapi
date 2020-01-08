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
     * @param string $user_order_no 商户提交的订单号，最长32位（商户保证其唯一性）
     * @param string $goods_no 产品编号（具体由橙券商务提供）
     * @param int $count 购买数量（只能为正整数，最大等于50）
     * @param string $mobile 接受卡密短信手机号
     * @return CQApiResponse
     */
    public function orderPay(string $user_order_no, string $goods_no, int $count, string $mobile = '')
    {
        $params = [
            'user_order_no' => $user_order_no,
            'goods_no'      => $goods_no,
            'count'         => $count,
            'mobile'        => $mobile,
        ];
        return $this->request("coupon/order/pay", $params);
    }

    /**
     * 商户卡券订单查询接口
     * @param string $user_order_no 商户提交的订单号，最长32位（商户保证其唯一性）
     * @return CQApiResponse
     */
    public function orderQuery(string $user_order_no)
    {
        $params = [
            'user_order_no' => $user_order_no,
        ];
        return $this->request("coupon/order/query", $params);
    }

    /**
     * 查询卡券品牌接口
     * @return CQApiResponse
     */
    public function typeList()
    {
        $params = [
            //无应用参数
        ];
        return $this->request("coupon/type/list", $params);
    }

    /**
     * 查询卡券品牌产品接口
     * @param string $goods_type_id 产品品牌id（具体参照查询品牌接口返回）
     * @return CQApiResponse
     */
    public function typeGoodsList(string $goods_type_id)
    {
        $params = [
            'goods_type_id' => $goods_type_id
        ];
        return $this->request("coupon/type/goods/list", $params);
    }

    /**
     * 查询卡券产品库存接口
     * @param string $goods_no 产品编号
     * @return CQApiResponse
     */
    public function goodsStock(string $goods_no)
    {
        $params = [
            'goods_no' => $goods_no
        ];
        return $this->request("coupon/goods/stock", $params);
    }

    /**
     * 商户查询卡券产品使用须知接口
     * @param string $goods_no 产品编号（具体参照查询卡券产品接口返回）
     * @return CQApiResponse
     */
    public function goodsNotes(string $goods_no)
    {
        $params = [
            'goods_no' => $goods_no
        ];
        return $this->request("coupon/goods/notes", $params);
    }

}