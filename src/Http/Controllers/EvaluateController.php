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
    public function store(Request $request, Client $client)
    {
        $url = config('xiexing.evaluate.url');

        if (empty($url)) {
            throw new \Exception('请配置落户评测转发地址');
        }

        $response = $client->post($url.'/site/curl-store', [
            'json' => $request->all()
        ]);

        $content = $response->getBody()->getContents();

        return response()->json(json_decode($content));
    }
}
