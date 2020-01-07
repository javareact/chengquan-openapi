# fulu-openapi

# 1. Require with Composer
```
composer require JavaReact/CQApi
```

# 2. Example
```
use GuzzleHttp\Client;
use JavaReact\CQApi\Order;

$goods = new Goods("appKey", "secret", function() {
    return new Client([
        "base_uri" => "https://openapi.fulu.com/api/getway",
    ]);
});

$response = $goods->fuluGoodsInfoGet("productid");
if($response->getStatusCode() == 200) {
    $json = $response->json();
    $result = $response->result();
}
```