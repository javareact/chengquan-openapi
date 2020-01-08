<?php

namespace Test\CQApi;

use JavaReact\CQApi\CQApiResponse;
use PHPUnit\Framework\TestCase;

/**
 * Class BaseTest 测试基类
 * @package Test\CQApi
 */
class BaseTest extends TestCase
{

    /**
     * @var bool 调试模式
     */
    protected $isDebug = false;

    /**
     * 输出结果
     * @param CQApiResponse $response
     */
    public function dump(CQApiResponse $response)
    {
        $this->isDebug && var_export($response->json());
    }

}