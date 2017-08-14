@extends('web.layout')
@section('title')
    {{$pager->title or $pager->name . ' - '.system_config('webname')}}
@endsection
@section('description', $pager->description)
@section('keywords', $pager->keyword)
@section('cssImport')
@endsection
@section('content')
    <div class="main-content article">
        <h2>{{$pager->title or $pager->name}}</h2>
        {{--<p class="info">发布时间：2017-05-06 13:46:04     发布作者： admin</p>--}}
        <hr/>
        <div class="content">
            {!! $pager->content !!}
        </div>


    </div>

@endsection

@section('jsImport')
@endsection