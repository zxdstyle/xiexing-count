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

class EvaluateController extends Controller
{
    public function index()
    {
        return $this->view('evaluate');
    }

    /**
     * 落户自测接口转发
     * @param Request $request
     * @param Client $client
     * @return mixed
     * @throws \Exception
     */
    public function store(Request $request, Client $client, Captcha $captcha)
    {
        $url = config('xiexing.evaluate.url');

        if (empty($url)) {
            throw new \Exception('请配置落户评测转发地址');
        }

        $params = $request->all();

        $isPass = true;

        # 最后一次提交增加请求次数
        if ($params['step'] === 'submit') {
            # 检测请求次数是否超过三次 超过三次返回图像验证码
            $isPass = $captcha->check($request, 'evaluate');

            $captcha->addTimes($request, 'evaluate');
        }

        if ($isPass) {
            $response = $client->post($url.'/site/curl-store', [
                'json' => $request->all()
            ]);

            $content = $response->getBody()->getContents();

            return response()->json(json_decode($content));
        } else {
            return response()->json(['code' => false,'prompt' => '失败','img_code' => 1]);
        }

    }
}
