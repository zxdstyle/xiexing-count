<?php

namespace Zxdstyle\Count\Http\Controllers;

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
}
