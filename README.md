# 橙券-权益营销方案服务商
### ChengQuan-openapi
### PHP-SDK

# 1. Require with Composer
```
composer require javareact/cq-api
```

# 2. Example
```
use GuzzleHttp\Client;
use JavaReact\CQApi\CQBalance;

$goods = new CQBalance("appKey", "secret", function() {
    return new Client([
        "base_uri" => \JavaReact\CQApi\Client::DEFAULT_GATEWAY,//可省略
    ]);
});

$response = $balance->balanceGet("productid");
if($response->getStatusCode() == 200) {
    $json = $response->json();
    $result = $response->result();
}
```