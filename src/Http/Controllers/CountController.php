<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2019-11-09
 * Time: 09:27
 */

namespace Zxdstyle\Count\Http\Controllers;


class CountController extends Controller
{
    public function index()
    {
        return view('count::count');
    }
}
