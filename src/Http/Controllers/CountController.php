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
    public function store(Request $request, Client $client)
    {
        $url = config('xiexing.count.url');

        if (empty($url)) {
            throw new \Exception('请配置积分计算器转发地址');
        }

        $response = $client->post($url.'/site/curl', [
            'json' => $request->input('data')
        ]);

        $content = $response->getBody()->getContents();

        return response()->json(json_decode($content));
    }
}
