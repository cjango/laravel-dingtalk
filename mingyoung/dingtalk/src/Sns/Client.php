<?php

/*
 * This file is part of the mingyoung/dingtalk.
 *
 * (c) mingyoung <mingyoungcheung@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyDingTalk\Sns;

use EasyDingTalk\Kernel\BaseClient;
use EasyDingTalk\Kernel\MakesHttpRequests;

/**
 * Class Client.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Client extends BaseClient
{
    use MakesHttpRequests;

    public function code(string $code)
    {
        $result = $this->request('POST', 'sns/get_persistent_code', [
            'query' => ['access_token' => $this->token()],
            'json'  => ['tmp_auth_code' => $code],
        ]);

        return $this->sns_token($result['openid'], $result['persistent_code']);
    }

    public function sns_token($openid, $persistent_code)
    {
        $result = $this->request('POST', 'sns/get_sns_token', [
            'query' => ['access_token' => $this->token()],
            'json'  => [
                'openid'          => $openid,
                'persistent_code' => $persistent_code,
            ],
        ]);

        return $this->info($result['sns_token']);
    }

    public function info($sns_token)
    {
        $result = $this->request('GET', 'sns/getuserinfo', [
            'query' => ['sns_token' => $sns_token],
        ]);
        return $this->app['user']->toUserId($result['user_info']['unionid']);
    }

    public function token()
    {
        if ($value = $this->app['cache']->get($this->cacheKey())) {
            return $value;
        }

        $result = $this->request('GET', 'sns/gettoken', [
            'query' => $this->credentials(),
        ]);

        $this->setToken($token = $result['access_token'], 7000);

        return $token;
    }

    /**
     * @param string                 $token
     * @param int|\DateInterval|null $ttl
     *
     * @return $this
     */
    public function setToken(string $token, $ttl = null)
    {
        $this->app['cache']->set($this->cacheKey(), $token, $ttl);

        return $this;
    }

    /**
     * @return array
     */
    protected function credentials(): array
    {
        return [
            'appid'     => $this->app['config']->get('appid'),
            'appsecret' => $this->app['config']->get('appsecret'),
        ];
    }

    /**
     * @return string
     */
    protected function cacheKey(): string
    {
        return 'easydingtalk.sns_access_token.' . md5(json_encode($this->credentials()));
    }
}
