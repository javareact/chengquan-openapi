<?php

declare(strict_types=1);

namespace Test\CQApi;


use GuzzleHttp\Client;
use JavaReact\CQApi\CQOrder;
use Monolog\Logger;

/**
 * Class OrderTest
 * @package Test\CQApi
 * @internal
 * @covers \JavaReact\CQApi\Order
 */
class OrderTest extends BaseTest
{
    /** @var CQOrder */
    protected $order;

    protected function setUp(): void
    {
        parent::setUp();
        $logger = new Logger("stdout");
        $logger->pushHandler(new StdoutHandler());
        $this->order   = new CQOrder('app_id', 'app_key', function () {
            return new Client([
                "base_uri" => \JavaReact\CQApi\Client::TEST_GATEWAY,
            ]);
        }, $logger);
        $this->isDebug = true;//输出结果
    }

    /**
     * 话费充值接口
     */
    public function testTelPay()
    {
        $response = $this->order->telPay(strval(time()), '13800138000', 100);
        $this->dump($response);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(true, $response->isSuccess());
        $this->assertSame('15020190001', $response->result("app_id"));
    }

    /**
     * 流量充值接口
     */
    public function testGprsPay()
    {
        $response = $this->order->gprsPay(strval(time()), '13800138000', 500, 'MONTH', 1);
        $this->dump($response);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(true, $response->isSuccess());
        $this->assertSame('15020190001', $response->result("app_id"));
    }

    /**
     * 加油卡充值接口
     */
    public function testOilPay()
    {
        $response = $this->order->oilPay(strval(time()), '1000113200005437747', 500);
        $this->dump($response);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(true, $response->isSuccess());
        $this->assertSame('15020190001', $response->result("app_id"));
    }

    /**
     * 腾讯业务接口
     */
    public function testQqPay()
    {
        $response = $this->order->qqPay(strval(time()), '851347180', 1, 1);//查询不到产品
        $this->dump($response);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(true, $response->isSuccess());
        $this->assertSame('15020190001', $response->result("app_id"));
    }

    /**
     * 视频充值接口
     */
    public function testVideoPay()
    {
        $response = $this->order->videoPay(strval(time()), '851347180', 1);//查询不到产品
        $this->dump($response);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(true, $response->isSuccess());
        $this->assertSame('15020190001', $response->result("app_id"));
    }

    /**
     * 直充订单查询
     */
    public function testOrderGet()
    {
        $response = $this->order->orderGet('1578467122');
        $this->dump($response);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(true, $response->isSuccess());
        $this->assertSame('15020190001', $response->result("app_id"));
    }
}