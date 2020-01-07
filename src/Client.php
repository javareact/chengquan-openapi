<?php

declare(strict_types=1);

namespace JavaReact\CQApi;

use Closure;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\TransferException;
use JavaReact\CQApi\Exception\ClientException;
use JavaReact\CQApi\Exception\ServerException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

abstract class Client
{
    /**
     * @var string
     */
    const DEFAULT_VERSION = "2.0";

    /**
     * @var string
     */
    const DEFAULT_FORMAT = "json";

    /**
     * @var string
     */
    const DEFAULT_CHARSET = "utf-8";

    /**
     * @var string
     */
    const DEFAULT_SIGN_TYPE = "md5";

    /**
     * @var string
     */
    const DEFAULT_APP_AUTH_TOKEN = "";

    /**
     * @vars string
     */
    protected $appKey;

    /**
     * @var string
     */
    protected $secret;

    /**
     * @var string
     */
    protected $version = self::DEFAULT_VERSION;

    /**
     * @var string
     */
    protected $format = self::DEFAULT_FORMAT;

    /**
     * @var string
     */
    protected $charset = self::DEFAULT_CHARSET;

    /**
     * @var string
     */
    protected $signType = self::DEFAULT_SIGN_TYPE;

    /**
     * @var string
     */
    protected $appAuthToken = self::DEFAULT_APP_AUTH_TOKEN;

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
     * @param string $appKey
     * @param string $secret
     * @param Closure $clientFactory
     * @param LoggerInterface|null $logger
     */
    public function __construct(string $appKey, string $secret, Closure $clientFactory, LoggerInterface $logger = null)
    {
        $this->appKey        = $appKey;
        $this->secret        = $secret;
        $this->clientFactory = $clientFactory;
        $this->logger        = $logger ?? new NullLogger();
    }

    /**
     * @param string $token
     */
    public function setAppAuthToken(string $token): void
    {
        $this->appAuthToken = $token;
    }

    /**
     * @param array $options
     * @param array $availableOptions
     * @return array
     */
    protected function resolveOptions(array $options, array $availableOptions): array
    {
        return array_intersect_key($options, array_flip($availableOptions));
    }

    /**
     * @param string $method
     * @param string $apiURI
     * @param array $options
     * @return CQApiResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function request(string $method, string $apiURI, array $options = []): CQApiResponse
    {
        $this->logger->debug(sprintf("CQApi Request [%s] %s", strtoupper($method), $apiURI));
        try {
            $clientFactory = $this->clientFactory;
            $client        = $clientFactory($options);
            if (!$client instanceof ClientInterface) {
                throw new ClientException(sprintf('The client factory should create a %s instance.', ClientInterface::class));
            }
            $parameters      = [
                "app_key"        => $this->appKey,
                "timestamp"      => date("Y-m-d H:i:s", time()),
                "version"        => $this->version,
                "format"         => $this->format,
                "charset"        => $this->charset,
                "sign_type"      => $this->signType,
                "app_auth_token" => $this->appAuthToken,
                "biz_content"    => json_encode($options["json"]),
            ];
            $options["json"] = array_merge([
                "sign" => $this->getSign($parameters),
            ], $parameters);
            $response        = $client->request($method, $apiURI, $options);
        } catch (TransferException $e) {
            $message = sprintf("Something went wrong when calling fulu (%s).", $e->getMessage());
            $this->logger->error($message);
            throw new ServerException($e->getMessage(), $e->getCode(), $e);
        }
        return new CQApiResponse($response);
    }

    /**
     * @param array $parameters
     * @return string
     */
    protected function getSign(array $parameters): string
    {
        if (array_key_exists("sign", $parameters)) {
            unset($parameters["sign"]);
        }
        return Sign::getSign($parameters, $this->secret);
    }


}