<?php

declare(strict_types=1);

namespace JavaReact\CQApi;

use Closure;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\TransferException;
use JavaReact\CQApi\Exception\ClientException;
use JavaReact\CQApi\Exception\ServerException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

abstract class Client
{
    /** @var string */
    const DEFAULT_GATEWAY = 'https://api.chengquan.cn/';

    /**
     * @vars string
     */
    protected $appId;

    /**
     * @var string
     */
    protected $appKey;

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
     * @param string $app_id
     * @param string $app_key
     * @param Closure $clientFactory
     * @param LoggerInterface|null $logger
     */
    public function __construct(string $app_id, string $app_key, Closure $clientFactory, LoggerInterface $logger = null)
    {
        $this->appId         = $app_id;
        $this->appKey        = $app_key;
        $this->clientFactory = $clientFactory;
        $this->logger        = $logger ?? new NullLogger();
    }

    /**
     * 发送请求
     * @param string $apiURI
     * @param array $parameters
     * @param string $method
     * @return CQApiResponse
     */
    protected function request(string $apiURI, array $parameters = []): CQApiResponse
    {
        $this->logger->debug(sprintf("CQApi Request [%s] %s", 'GET', $apiURI));
        try {
            $clientFactory = $this->clientFactory;
            /** @var ClientInterface $client */
            $client = $clientFactory();
            if (!$client instanceof ClientInterface) {
                throw new ClientException(sprintf('The client factory should create a %s instance.', ClientInterface::class));
            }
            if (empty($client->getConfig('base_uri'))) {
                $apiURI = self::DEFAULT_GATEWAY . $apiURI;//缺省网关
            }
            $parameters ['app_id']    = $this->appId;
            $parameters ['timestamp'] = intval(microtime(true) * 1000);//毫秒
            $options['verify']        = false;
            $options["query"]         = array_merge([
                "sign" => $this->getSign($parameters),
            ], $parameters);//查询字符串
            $response                 = $client->request('GET', $apiURI, $options);
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


}