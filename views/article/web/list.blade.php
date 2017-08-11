@extends('web.layout')
@section('title', '文章列表 - 众商平台')
@section('description', '')
@section('keywords', '')
@section('cssImport')
@endsection
@section('content')

    <div class="main-content article-list">
        @php
{{--            $categoriesStr = [];--}}
{{--            foreach ($categories as $category){--}}
{{--                $categoriesStr[] = $category->name;--}}
{{--                if($category->tag == 'article') break;--}}
{{--            }--}}
        @endphp

        <ol class="am-breadcrumb">
            <li><a href="{{route('pager@home')}}">首页</a></li>
            <li class="am-active">文章中心</li>
        </ol>
        <ul>
        @foreach($data as $item)
            <li>
                <a href="{{route('article@web@detail',['id'=> $item['id']])}}" title="{{$item['excerpt']}}">
                    <img src="{{empty($item['pic']) ? asset('images/default.png') : asset($item['pic'])}}">
                    <div>
                        <p>
                            {{$item['title']}}
                        </p>
                        <p class="time">
                            {{$item['push_time'] or $item['created_at']}}
                        </p>
                    </div>
                </a>
            </li>
        @endforeach
        </ul>

        {{$pager->links()}}


    </div>

@endsection

@section('jsImport')
@endsection