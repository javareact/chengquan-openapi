<?php

declare(strict_types=1);

namespace JavaReact\CQApi;

use Closure;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\TransferException;
use JavaReact\CQApi\Exception\ClientException;
use JavaReact\CQApi\Exception\ServerException;
use JavaReact\CQApi\Tools\Sign;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Class Client
 * @package JavaReact\CQApi
 */
abstract class Client
{
    /** @var string 默认网关 */
    const DEFAULT_GATEWAY = 'https://api.chengquan.cn/';

    /** @var string 测试网关 */
    const TEST_GATEWAY = 'http://test.api.chengquan.vip:11140/';

    /** @var string APP_ID */
    private $appId;

    /** @var string APP_KEY */
    private $appKey;

    /**
     * @var Closure
     */
    private $clientFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Client constructor.
     * @param string $app_id APP_ID
     * @param string $app_key APP_KEY
     * @param Closure|null $clientFactory
     * @param LoggerInterface|null $logger
     */
    public function __construct(string $app_id, string $app_key, Closure $clientFactory = null, LoggerInterface $logger = null)
    {
        $this->appId         = $app_id;
        $this->appKey        = $app_key;
        $this->clientFactory = $clientFactory;
        $this->logger        = $logger ?? new NullLogger();
    }

    /**
     * 发送请求
     * @param string $apiURI 请求地址
     * @param array $parameters 应用级参数
     * @return CQApiResponse
     * @throws ServerException
     */
    protected function request(string $apiURI, array $parameters = []): CQApiResponse
    {
        $this->logger->debug(sprintf("CQApi Request [%s] %s", 'GET', $apiURI));
        try {
            $clientFactory = $this->clientFactory;
            if ($clientFactory instanceof Closure) {
                /** @var ClientInterface $client */
                $client = $clientFactory();
            } else {
                $client = new \GuzzleHttp\Client;
            }
            if (!$client instanceof ClientInterface) {
                throw new ClientException(sprintf('The client factory should create a %s instance.', ClientInterface::class));
            }
            if (empty($client->getConfig('base_uri'))) {
                $apiURI = self::DEFAULT_GATEWAY . $apiURI;//缺省网关
            }
            $parameters['app_id']    = $this->appId;
            $parameters['timestamp'] = intval(microtime(true) * 1000);//毫秒
            $parameters['sign']      = $this->getSign($parameters);
            $options['verify']       = false;//关闭SSL验证
            $options["query"]        = $parameters;//查询字符串
            $response                = $client->request('GET', $apiURI, $options);
        } catch (TransferException $e) {
            $message = sprintf("Something went wrong when calling fulu (%s).", $e->getMessage());
            $this->logger->error($message);
            throw new ServerException($e->getMessage(), $e->getCode(), $e);
        } catch (GuzzleException $e) {
            $message = sprintf("Something went wrong when calling fulu (%s).", $e->getMessage());
            $this->logger->error($message);
            throw new ServerException($e->getMessage(), $e->getCode(), $e);
        }
        return new CQApiResponse($response);
    }

    /**
     * 获取签名
     * @param array $parameters
     * @return string
     */
    protected function getSign(array $parameters): string
    {
        if (array_key_exists("sign", $parameters)) {
            unset($parameters["sign"]);
        }
        return Sign::getSign($parameters, $this->appKey);
    }

    /**
     * 验证签名
     * @param array $parameters POST数组
     * @return bool
     */
    public function verifySign(array $parameters)
    {
        if (!array_key_exists('sign', $parameters) || empty($parameters['sign'])) {
            return false;
        }
        $oriSign = $parameters['sign'];
        $newSign = $this->getSign($parameters);
        if ($oriSign === $newSign) {
            return true;
        }
        return false;
    }

}