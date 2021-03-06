<?php
/**
 * Swoft Entity Cache
 *
 * @author   limx <limingxin@swoft.org>
 * @link     https://github.com/limingxinleo/swoft-easywechat
 */
namespace SwoftTest\Cases\EasyWeChat;

use GuzzleHttp\ClientInterface;
use Swoftx\EasyWeChat\Factory;
use SwoftTest\Cases\AbstractTestCase;

class HttpClientTest extends AbstractTestCase
{
    public function testInstanceOfSwoftHttpClient()
    {
        $app = Factory::basicService([]);
        $httpClient = $app->http_client;
        $this->assertInstanceOf(ClientInterface::class, $httpClient);
    }

    public function testAccessToken()
    {
        $log = alias('@runtime');
        $config = [
            'app_id' => env('WECHAT_APP_ID'),
            'secret' => env('WECHAT_SECRET'),

            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',

            'log' => [
                'level' => 'debug',
                'file' => $log . '/wechat.log',
            ],
        ];

        $app = Factory::officialAccount($config);
        $res = $app->access_token->getToken(true);
        $this->assertArrayHasKey('access_token', $res);
        $this->assertArrayHasKey('expires_in', $res);
    }

    public function testAccessTokenByCo()
    {
        go(function () {
            $this->testAccessToken();
        });
    }
}
