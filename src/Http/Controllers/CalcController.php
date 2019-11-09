<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2019-11-09
 * Time: 17:33
 */

namespace Zxdstyle\Count\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Zxdstyle\Count\Http\Services\Captcha;

class CalcController extends Controller
{
    public function store(Request $request, Client $client, Captcha $captcha)
    {
        $url = config('xiexing.calc.url');

        $params = $request->input('data');

        if (empty($url)) {
            throw new \Exception('请配置个税社保计算器转发地址');
        }

        # 检测请求次数是否超过三次 超过三次返回图像验证码
        $isPass = $captcha->check($request, 'calc');

        $captcha->addTimes($request, 'calc');


        # 检测请求次数是否超过三次 超过三次返回图像验证码
        if ($isPass) {
            $response = $client->post($url.'/site/curl-form-input', [
                'json' => $params
            ]);

            $content = $response->getBody()->getContents();

            return response()->json(json_decode($content));
        } else {
            return response()->json(['code' => false,'prompt' => '失败','img_code' => 1]);
        }
    }
}
