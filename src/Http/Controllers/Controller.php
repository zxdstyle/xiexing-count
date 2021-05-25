<?php

namespace Zxdstyle\Count\Http\Controllers;

use GuzzleHttp\Client;
use WhichBrowser\Parser;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function view($view, $data = [])
    {
        $result = new Parser($_SERVER['HTTP_USER_AGENT']);

        $isMobile = $result->isMobile();
        if ($isMobile) {
            return view('xiexing::m.'.$view, $data);
        } else {
            return view('xiexing::pc.'.$view, $data);
        }
    }

    public function success($message = "success", $data = [])
    {
        return response()->json([
            'code' => 200,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function failed($message = "failed", $code = 400)
    {
        return response()->json([
            'code' => $code,
            'message' => $message
        ], $code);
    }

    /**
     * @param $data
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function pushToDataV2($data)
    {
        $url = config('xiexing.data_system_url');

        if (empty($url)) {
            throw new \Exception('请配置 DATA 系统地址');
        }

        // data系统接收数据的地址
        $dataUrl = $url.'/api/form-input';

        $client = new Client();
        
        $client->setDefaultOption('verify', false);

        return $client->post($dataUrl, [
            "headers" => [
                'X-Requested-With' => 'XMLHttpRequest'
            ],
            "json" => $data
        ]);
    }
}
