<?php
use App\Models\Option;

$config = Option::getWebSiteConfig();
?>

@extends('point.layouts.m')

@section('header')
    <div class="m_header">
        <div class="header">
            <a href="javascript:history.go(-1)">
                <i class="iconfont icon-jiantouzuo"></i>
            </a>
            <div class="title">落户自测</div>
        </div>
    </div>
@stop

@section('style')
    <link rel="stylesheet" href="{{ asset('/web/css/m_list.css?v=201910281704') }}">
    <link rel="stylesheet" type="text/css" href="../zjtrain/styles/pc/global.min.css?v=201908261112" media="screen and (min-width: 768px)"/>
    <link rel="stylesheet" type="text/css" href="../zjtrain/styles/pc/pages/Integral_calculation.min.css?v=201908261112" media="screen and (min-width: 768px)"/>
    <link rel="stylesheet" type="text/css" href="../zjtrain/styles/pc/pages/stay_test.min.css?v=201908261112" media="screen and (min-width: 768px)"/>
    <link rel="stylesheet" type="text/css" href="../zjtrain/styles/m/global.min.css?v=201908261112" media="screen and (max-width: 768px)"/>
    <link rel="stylesheet" type="text/css" href="../zjtrain/styles/m/pages/mCalc.min.css?v=201908261133" media="screen and (max-width: 768px)">
    <link rel="stylesheet" type="text/css" href="../zjtrain/styles/m/pages/mStayTest.min.css?v=201903111708" media="screen and (max-width: 768px)">
    <style type="text/css">
        [v-cloak] { display: none }
        #nav,#kong,#ft{
            height: 0;
        }
        .mask{
            position: fixed;
            width: 100%;
            height: 100%;
            background:rgba(0,0,0,.5);
            top:0;
            left: 0;
        }
        em{
            font-style: normal;
        }
        .fix-box{
            display: none;
        }
    </style>
@stop

@section('content')
    @include('components.evaluate')
@stop

@section('footer')
    @include('point.layouts.mfooter', ['config' => $config])
@stop

@section('js')
    <script src="{{ asset('/zjtrain/js/lib/jquery-1.7.2.min.js') }}"></script>
    <script src="{{ asset('/zjtrain/js/lib/vue.min.js') }}"></script>
    <script src="{{ asset('/zjtrain/js/lib/vue-resource.min.js') }}"></script>
    <script>
        function screenLoad(){
            if(screen.width<=768){
                document.write('<script src="../zjtrain/js/m/lib/lib-flexible-2.0/index.js"><\/script>');
                document.write('<script src="../zjtrain/js/m/guiji.min.js"><\/script>');
                document.write('<script src="../zjtrain/js/m/commonForm.min.js"><\/script>');
                document.write('<script src="../zjtrain/js/m/mStayTest.min.js?v=201903110931"><\/script>');
            }else{
                document.write('<script src="../zjtrain/js/pc/guiji.min.js"><\/script>');
                document.write('<script src="../zjtrain/js/pc/commonForm.min.js"><\/script>');
                document.write('<script src="../zjtrain/js/pc/stayTest.min.js?v=201903110931"><\/script>');
            }
        }
        screenLoad()
    </script>
@stop
