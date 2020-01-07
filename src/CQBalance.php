<?php


namespace JavaReact\CQApi;

/**
 * Class CQBalance 基础数据
 * @package JavaReact\CQApi
 */
class CQBalance extends Client
{

    /**
     * 商户查询账户余额的接口
     */
    public function balanceGet()
    {
        $params = [
        ];
        return $this->request("POST", "https://api.chengquan.cn/user/balance/get", $params);
    }

}