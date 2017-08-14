@extends('web.layout')
@section('title')
    {{$pager->title or $pager->name.' - '.system_config('webname')}}
@endsection
@section('description', $pager->description)
@section('keywords', $pager->keyword)
@section('cssImport')
    <style>
        @media only screen and (max-width: 640px){
            h2{
                margin-top: 10px;
                font-size: 18px;
            }
            p.info{
                font-size: 14px;
            }
        }

    </style>
@endsection
@section('content')
    <div class="main-content article">
        <ol class="am-breadcrumb">
            <li><a href="{{route('pager@home')}}">首页</a></li>
            <li><a href="{{route('article@web@list')}}">文章中心</a></li>
            <li class="am-active">文章详情</li>
        </ol>
        <h2>{{$pager->title or $pager->name}}</h2>
        <p class="info">发布时间：{{$pager->push_time or $pager->created_at}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;作者： {{$pager->member->nickname or $pager->member->username}}</p>
        <hr/>

        <div class="content">
            {!! $pager->content !!}
        </div>


    </div>

@endsection

@section('jsImport')
@endsection