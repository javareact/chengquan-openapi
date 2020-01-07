<?php

declare(strict_types=1);

namespace JavaReact\CQApi;


use JavaReact\CQApi\Exception\ServerException;
use Psr\Http\Message\ResponseInterface;

/**
 * 注意：
 * 若在使用扩展方法前使用getBody()->getContents()方法的话
 * 需要自行解析body内容，扩展方法全部失效
 * Class CQApiResponse
 * @package JavaReact\CQApi
 */
class CQApiResponse
{
    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @var null
     */
    private $bodyBytes = null;

    /**
     * CQApiResponse constructor.
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return  $this->response->{$name}(...$arguments);
    }

    /**
     * @param string|null $key
     * @param mixed|null $default
     * @return mixed|mixed
     */
    public function json(string $key = null, $default = null)
    {
        if (strstr( strtolower($this->response->getHeaderLine('Content-Type')), 'application/json') === false ) {
            throw new ServerException('The Content-Type of response is not equal application/json');
        }
        if (is_null($this->bodyBytes)) {
            $this->bodyBytes = $this->response->getBody()->getContents();
        }
        $data = json_decode($this->bodyBytes, true);
        if (is_null($key)) {
            return $data;
        }
        if (array_key_exists($key, $data)) {
            return $data[$key];
        } else {
            return $default;
        }
    }

    /**
     * @param bool $checkSign
     * @return bool
     */
    public function isSuccess(bool $checkSign = true): bool
    {
        if($this->json("code") === 0) {
            if($checkSign===true) {
                //todo
                return true;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * @return int
     */
    public function code(): int
    {
        return (Integer) $this->json("code", 999999); // 如果无则返回999999
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return $this->json("message");
    }

    /**
     * @param string|null $key
     * @return mixed|null
     */
    public function result(string $key = null)
    {
        $result = json_decode($this->json("result"), true);
        if (is_null($key)) {
            return $result;
        }
        if (array_key_exists($key, $result)) {
            return $result[$key];
        } else {
            throw new ServerException(sprintf('UnKnow response param "%s"', $key));
        }
    }
}