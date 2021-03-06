<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2019-11-09
 * Time: 15:44
 */

namespace Zxdstyle\Count\Http\Services;

use Validator;
use Illuminate\Http\Request;

class Captcha
{
    public function check(Request $request, $interface)
    {
        if ($interface === 'evaluate') {
            $params = $request->all();
        } else {
            $params = $request->input('data');
        }

        $key = $interface.'submit_time';

        if (!empty($request->input('img_code')) || !empty($request->input('data.img_code')) || !empty($request->input('captcha'))) {

            $img_code = $request->input('img_code') ?? $request->input('captcha');

            $validator = Validator::make([
                'img_code' => $img_code ?? $request->input('data.img_code')
            ], [
                'img_code' => 'required|captcha'
            ]);

            if ($validator->fails()) {
                return false;
            }
            $request->session()->put($key, 0);
        } else {
            $times = $request->session()->get($key);
            if ($times && $times >= 3) {
                return false;
            }
        }
        return true;
    }

    public function addTimes(Request $request, $interface)
    {
        $key = $interface.'submit_time';

        if ($request->session()->has($key)) {
            $times = $request->session()->get($key);
            $times++;
        } else {
            $times = 1;
        }

        $request->session()->put($key, $times);
    }
}
