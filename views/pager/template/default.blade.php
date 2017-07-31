@extends('web.layout')
@section('title', $pager->name.' - 众商平台')
@section('description', $pager->description)
@section('keywords', $pager->keyword)
@section('cssImport')
@endsection
@section('content')

    <div class="main-content article">
        <h2>文章标题</h2>
        {{--<p class="info">发布时间：2017-05-06 13:46:04     发布作者： admin</p>--}}
        <hr/>

        <div class="content">
            {!! $pager->content !!}
        </div>


    </div>

@endsection

@section('jsImport')
@endsection