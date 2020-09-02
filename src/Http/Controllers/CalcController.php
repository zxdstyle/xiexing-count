<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2019-11-09
 * Time: 17:33
 */

namespace Zxdstyle\Count\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Psr\Http\Message\ResponseInterface;
use Zxdstyle\Count\Http\Services\Captcha;
use Zxdstyle\Count\Model\Visitor;

/**
 * 社保个税
 * Class CalcController
 * @package Zxdstyle\Count\Http\Controllers
 */
class CalcController extends Controller
{
    public function store(Request $request, Visitor $visitor, Captcha $captcha)
    {
        $validate = Validator::make($request->input('data'), [
            "phone" => ['required', 'regex:/^1[345678]\d{9}$/'],
        ], [
            'phone.required' => "请输入手机号",
            'phone.regex' => "请输入正确的手机号",
        ]);

        if ($validate->fails()) {
            return [
                "code" => false,
                "prompt" => $validate->errors()->first()
            ];
        }

        # 检测请求次数是否超过三次 超过三次返回图像验证码
        $isPass = $captcha->check($request, 'calc');

        $captcha->addTimes($request, 'calc');

        if ($isPass) {
            $params = [
                "phone" => $request->input("data.phone"),
                "name" => $request->input("data.name", "未知"),
                "info" => $request->input("data.info", "用户通过在浏览积分网页时，留下的个人信息，无具体情况"),
                "country" => $request->input("data.url", "未知"),
                "method" => $request->input("data.method", "未知"),
            ];

            $visitor->fill($params)->save();

            //处理下
            $curlData = [
                'component' => 'TAX_CALCULATION',
                'phone' => $params['phone'],
                'url' => $params['country'],
                'old_tags' => $request->input("data.sourceChange", []),
                'url_data' => $request->input("data.source", ""),
                'info' => $params['info'],
                'old_url' => $request->input("data.old_url", ""),
                'enter_url' => $request->input("data.enter_url", ""),
            ];

            try {
                $response = $this->pushToDataV2($curlData)->getBody()->getContents();

                $out = json_decode($response, true);

                if ($out['code'] == -1) {
                    logger()->error("【社保个税表单提交错误】", $out);
                }
                $visitor->update(['crm' => $out['code'], 'notice' => $out['error'] ?? "success"]);

            } catch (\Exception $exception) {
                $error = $exception->getMessage();

                if ($exception instanceof ClientException) {
                    $response = $exception->getResponse()->getBody()->getContents();
                    logger()->error($response);
                    $error = json_decode($response)->error;
                }

                logger()->error("【社保个税表单提交错误】". $error);

                return $this->failed($error);
            }

            return $this->success();
        }

        return response()->json([
            'error' => "请求频繁",
            'captcha' => captcha_src(),
            'code' => 429 //your custom code
        ], 429);
    }
}
