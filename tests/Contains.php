<?php

declare(strict_types=1);

namespace Test\CQApi;

date_default_timezone_set("Asia/Shanghai");

class Contains
{
    const TEST_GATEWAY = "https://pre-openapi.fulu.com/api/getway";

    const TEST_APP_KEY = "i4esv1l+76l/7NQCL3QudG90Fq+YgVfFGJAWgT+7qO1Bm9o/adG/1iwO2qXsAXNB";

    const TEST_SECRET = "0a091b3aa4324435aab703142518a8f7";

    const TEST_MEMBER_CODE = "9000358";

    const TEST_MERCHANT_NAME = "OpenApi2.0对接专用商户";

    const TEST_NETWORK_IPS = ["118.31.50.117", "114.55.126.1"];

    const TEST_MOBILE = "15972368779";

    const TEST_GOODS_PRODUCT_ID = "10000587";

    const TEST_GOODS_PRODUCT_NAME = "卡密测试商品";

    const TEST_GOODS_TEMPLATE_ID = "e1dac0ea-dc86-4c9d-a778-c9e19203ecb8";

    const TEST_ORDER_DATA_ADD_SUCCESS_PHONE = "15972368779";

    const TEST_ORDER_DATA_ADD_FAILURE_PHONE = "13971553804";
}