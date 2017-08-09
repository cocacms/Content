@extends('web.layout')
@section('title', $pager->title or $pager->name.' - 众商平台')
@section('description', $pager->description)
@section('keywords', $pager->keyword)
@section('cssImport')
@endsection
@section('content')
    <div class="main-content article">
        @php
            $cIds = [];
            $categoriesStr = [];
            if($categories instanceof \Baum\Extensions\Eloquent\Collection){
                foreach ($categories as $category){
                    $cIds[] = $category->id;
                    $categoriesStr[] = $category->name;
                }
            }else{
                foreach ($pager->categories as $category){
                    $cIds[] = $category->id;
                    $categoriesStr[] = $category->name;

                }
            }
        @endphp
        <ol class="am-breadcrumb">
            <li><a href="{{route('pager@home')}}">首页</a></li>
            <li><a href="{{route('article@web@list',['ids'=>implode('-',$cIds)])}}">{{count($categoriesStr) == 0 ? '文章列表' : implode(',',$categoriesStr)}}</a></li>
            <li class="am-active">{{$pager->title or $pager->name}}</li>
        </ol>
        <h2>{{$pager->title or $pager->name}}</h2>
        <p class="info">发布时间：{{$pager->push_time or $pager->created_at}}     发布作者： {{$pager->member->nickname or $pager->member->username}}</p>
        <hr/>

        <div class="content">
            {!! $pager->content !!}
        </div>


    </div>

@endsection

@section('jsImport')
@endsection