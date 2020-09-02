<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2019-11-09
 * Time: 09:27
 */

namespace Zxdstyle\Count\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Psr\Http\Message\ResponseInterface;
use Zxdstyle\Count\Model\Score;
use Illuminate\Support\Facades\Validator;
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
     * @param Captcha $captcha
     * @return mixed
     */
    public function store(Request $request, Captcha $captcha)
    {
        $post = $request->input('data');
        $validate = Validator::make($post, [
            "integral" => ['required'],
            "which" => ['required'],
            "answer" => ['required_unless:which,p12'],
            //"url" => ['required'],
            // "token" => ['required'],
        ]);
        if ($validate->fails()) {
            return response()->json([
                "status" => false,
                "prompt" => $validate->errors()->first()
            ], 400);
        }

        $isPass = true;

        # 最后一次提交增加请求次数
        if ($post['which'] === 'p12') {
            # 检测请求次数是否超过三次 超过三次返回图像验证码
            $isPass = $captcha->check($request, 'count');

            $captcha->addTimes($request, 'count');
        }

        if ($isPass) {
            $model = Score::query()->firstOrNew(['openid' => $post['integral']]);

            $model->phone = $post['tel'] ?? "";

            $step = [
                'p1'=>'one_step',
                'p2'=>'two_step',
                'p3'=>'three_step',
                'p4'=>'four_step',
                'p5'=>'five_step',
                'p6'=>'six_step',
                'p7'=>'seven_step',
                'p8'=>'eight_step',
                'p9'=>'nine_step',
                'p10'=>'ten_step',
                'p11'=>'eleven_step',
            ];

            if ($post['which'] != "p12") {
                $model[$step[$post['which']]] = $request->input('data.answer');
            }

            $model->fill($post)->save();

            if ($post['which'] == 'p12') {

                $params = array_merge($post, $model->toArray());

                $result = [
                    'component' => 'COUNT_CALC',
                    'score_id' => $model->id,
                    'phone'=>$params['phone'],
                    'url'=>$params['url'],
                    'old_tags' => isset($params['sourceChange']) ? $params['sourceChange'] : [],
                    'url_data' => isset($params['source']) ? $params['source'] : '',
                    'info' => isset($params['info']) ? $params['info'] : '无',
                    'old_url' => isset($params['old_url']) ? $params['old_url'] : '',
                    'enter_url' => isset($params['enter_url']) ? $params['enter_url'] : '',
                ];
                try {
                    $response = $this->pushToDataV2($result)->getBody()->getContents();

                    $out = json_decode($response, true);

                    $state = $out['code'] == -1 ? 0 : $out['code'];

                    if ($state == 0) {
                        logger()->error("【积分计算器表单提交错误】", $out);
                    }

                    $model->update(['crm' => $state]);

                } catch (\Exception $exception) {
                    $error = $exception->getMessage();

                    if ($exception instanceof ClientException) {
                        $response = $exception->getResponse()->getBody()->getContents();

                        $error = json_decode($response)->error;
                    }

                    logger()->error("【积分计算器表单提交错误】". $error);

                    return $this->failed($error);
                }
            }

            return $this->success();
        }

        return response()->json(['code' => false,'prompt' => '失败','img_code' => 1]);
    }

    public function captcha()
    {
        return response()->json('<img id="imgcode" src="'.captcha_src().'">');
    }
}
