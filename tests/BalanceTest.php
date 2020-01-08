<?php

declare(strict_types=1);

namespace Test\CQApi;


use GuzzleHttp\Client;
use JavaReact\CQApi\CQBalance;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;

/**
 * Class OrderTest
 * @package Test\CQApi
 * @internal
 * @covers \JavaReact\CQApi\Order
 */
class BalanceTest extends TestCase
{
    /** @var CQBalance */
    protected $balance;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $logger = new Logger("stdout");
        $logger->pushHandler(new StdoutHandler());
        $this->balance = new CQBalance('666', 'mykey', function () {
            return new Client([
                "base_uri" => \JavaReact\CQApi\Client::TEST_GATEWAY,
            ]);
        }, $logger);
    }

    public function testBalanceGet()
    {
        $response = $this->balance->balanceGet();
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(true, $response->isSuccess());
        $this->assertSame('666', $response->result("app_id"));
    }
}