<?php
/**
 * User: fanyawei
 * Date: 2024/1/3 14:40
 */

namespace Tesoon\Account\RequestSend;

use Exception;
use Tesoon\Account\InterfaceRequestSend;
use Tesoon\Account\RequestSend\Request\ApiRequestBase;

/**
 * 发送请求类
 */
abstract class AbstractRequestSend implements InterfaceRequestSend
{
    /**
     * @var string appID
     */
    public $appID;

    /**
     * @var string appSecret
     */
    public $appSecret;

    /**
     * @var string 请求域名
     */
    public $domain;

    /**
     * @var bool 是否debug环境
     */
    public $isDebug = false;

    /**
     * 发送请求
     * @param ApiRequestBase $request
     * @param bool $raw 默认false如果响应正文包含 JSON则进行解码
     * @return mixed
     */
    public function send(ApiRequestBase $request, bool $raw = false)
    {
        $url = $request->url;
        if (self::isRelative($url)) {
            $url = $this->domain.$url;
        }
        $requestOptions = $request->getRequestOptions();
        if ($this->isDebug) {
            $requestOptions[CURLOPT_SSL_VERIFYPEER] = 0;
            $requestOptions[CURLOPT_SSL_VERIFYHOST] = 0;
        }
        $curl = new Curl();
        $curl->setGetParams($request->requestParams)
            ->setHeaders($request->getRequestHeaders())
            ->setOptions($requestOptions);
        if ($beforeSend = $this->beforeSend($request, $curl) !== true) {
            return $beforeSend;
        }
        $this->encryptRequest($request, $curl);

        switch ($request->requestMethod) {
            case ApiRequestBase::REQUEST_METHOD_GET:
                $curl->get($url, $raw);
                break;
            case ApiRequestBase::REQUEST_METHOD_POST:
                $curl->post($url, $raw);
                break;
            default:
                throw new \Error('暂不支持的请求方法');
        }
        $this->afterSend($request, $curl);
        return $this->formatCurl($curl);
    }


    /**
     * @param Curl $curl
     */
    public function formatCurl(Curl $curl)
    {
        if (!empty($curl->errorText)) {
            throw new Exception($curl->errorText, $curl->errorCode);
        }

        switch ($curl->responseCode) {
            case '200'://正常返回
                return $curl->response;
            case '400'://常规错误
            case '401'://token无效
            default:
                $curlResponse = $curl->response;
                if (is_array($curlResponse) && isset($curlResponse['message'])) {
                    $curlResponse = $curlResponse['message'];
                }
                throw new Exception($curlResponse, $curl->responseCode);
        }
    }

    /**
     * 传入url是否为一个相对路径 true是一个相对地址
     * @param string $url the URL to be checked
     * @return bool
     */
    public static function isRelative(string $url):bool
    {
        return strncmp($url, '//', 2) && strpos($url, '://') === false;
    }

    /**
     * @param ApiRequestBase $request
     * @param Curl $curl
     * @return true|mixed 返回true继续请求，否则将终止请求并将本方法结果返回
     */
    abstract public function beforeSend(ApiRequestBase $request, Curl $curl);

    /**
     * @param ApiRequestBase $request
     * @param Curl $curl
     * @return void
     */
    abstract public function afterSend(ApiRequestBase $request, Curl $curl):void;

    /**
     * 对请求进行加密
     * @param ApiRequestBase $request
     * @param Curl $curl
     * @return void
     */
    abstract public function encryptRequest(ApiRequestBase $request, Curl $curl):void;
}
