<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2019-11-09
 * Time: 09:27
 */

namespace Zxdstyle\Count\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Psr\Http\Message\ResponseInterface;
use Zxdstyle\Count\Http\Services\Captcha;
use Zxdstyle\Count\Model\LuoHu;

class EvaluateController extends Controller
{
    public function index()
    {
        return $this->view('evaluate');
    }

    /**
     * 落户自测接口转发
     * @param Request $request
     * @param Captcha $captcha
     * @return mixed
     */
    public function store(Request $request, Captcha $captcha)
    {
        $validate = Validator::make($request->all(), [
            "key" => ['required'],
            "step" => ['required'],
            "answer" => ['required'],
        ]);
        if ($validate->fails()) {
            return [
                "status" => 400,
                "message" => $validate->errors()->first(),
                'img_code'=>0
            ];
        }

        $isPass = true;
        $step = $request->input("step");

        # 最后一次提交增加请求次数
        if ($step === 'submit') {
            # 检测请求次数是否超过三次 超过三次返回图像验证码
            $isPass = $captcha->check($request, 'evaluate');

            $captcha->addTimes($request, 'evaluate');
        }

        $params = $request->only(['key', "name", "phone"]);

        $luohu = LuoHu::query()->firstOrNew(['key' => $params['key']]);

        if ($step != 'submit') {
            $luohu->fill([
                'key' => $params['key'],
                $step => $request->input("answer")
            ])->save();

            return $this->success('记录成功');
        }

        if ($isPass && $step === 'submit') {
            $luohu->fill($params)->save();

            $curlData = [
                'component' => 'LUOHU_EVALUATE',
                'luohu_id' => $luohu->id,
                'name' => $params['name'],
                'phone' => $params['phone'],
                'url' => $request->input('url', '未知'),
                'old_tags' => $request->input('sourceChange', []),
                'url_data' => $request->input('source', []),
                'info' => $params['name'],
                'old_url' => $request->input('old_url', []),
                'enter_url' => $request->input('enter_url', []),
            ];

            try {
                $response = $this->pushToDataV2($curlData)->getBody()->getContents();

                $out = json_decode($response, true);

                $state = $out['code'] == -1 ? 0 : $out['code'];
                if ($state == 0) {
                    logger()->error("【落户自测表单提交错误】", $out);
                }

                $luohu->update(['crm' => $state]);

            } catch (\Exception $exception) {
                $error = $exception->getMessage();

                if ($exception instanceof ClientException) {
                    $response = $exception->getResponse()->getBody()->getContents();

                    $error = json_decode($response)->error;
                }

                logger()->error("【落户自测表单提交错误】". $error);

                return $this->failed($error);
            }

            return $this->success();
        }

        return ['code' => false,'prompt' => '失败','img_code' => 1];
    }
}
