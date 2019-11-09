<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2019-11-09
 * Time: 09:27
 */

namespace Zxdstyle\Count\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Zxdstyle\Count\Http\Services\Captcha;

class CountController extends Controller
{
    public function index()
    {
        return $this->view('count');
    }

    /**
     * 积分计算器数据转发
     * @param Request $request
     * @param Client $client
     * @return mixed
     * @throws \Exception
     */
    public function store(Request $request, Client $client, Captcha $captcha)
    {
        $url = config('xiexing.count.url');

        $params = $request->input('data');

        if (empty($url)) {
            throw new \Exception('请配置积分计算器转发地址');
        }

        # 检测请求次数是否超过三次 超过三次返回图像验证码
        $captcha = $captcha->check($request, 'count');

        # 最后一次提交增加请求次数
        if ($params['which'] === 'p12') {
            $captcha->addTimes($request, 'count');
        }

        # 检测请求次数是否超过三次 超过三次返回图像验证码
        if ($captcha) {
            $response = $client->post($url.'/site/curl', [
                'json' => $params
            ]);

            $content = $response->getBody()->getContents();

            return response()->json(json_decode($content));
        } else {
            return response()->json(['code' => false,'prompt' => '失败','img_code' => 1]);
        }
    }
}
