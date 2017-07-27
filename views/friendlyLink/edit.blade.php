@extends('layout.layout')
@section('title', '编辑')
@section('cssImport')
    <style type="text/css">
        .layui-form-item .layui-inline{ width:33.333%; float:left; margin-right:0; }
        @media(max-width:1240px){
            .layui-form-item .layui-inline{ width:100%; float:none; }
        }
    </style>
@endsection

@section('content')
    <form class="layui-form" style="width: 80%;">
        <input type="hidden" name="tag" value="{{$friendlyLink->tag}}">
        <div class="layui-form-item">
            <label class="layui-form-label">名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" value="{{$friendlyLink->name}}" placeholder="请输入名称" lay-verify="required" class="layui-input"/>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">链接</label>
            <div class="layui-input-block">
                <input type="text" name="link" value="{{$friendlyLink->link}}" placeholder="请输入链接/路由 路由参数用|隔开 例 admin@index|id=1|type=update" autocomplete="false" class="layui-input" lay-verify="required"/>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">打开方式</label>
            <div class="layui-input-block">
                <select name="target">
                    <option value="_self" {{$friendlyLink->target == '_self' ? 'selected':''}}>本页面</option>
                    <option value="_blank" {{$friendlyLink->target == '_blank' ? 'selected':''}}>新窗口</option>
                    <option value="_parent" {{$friendlyLink->target == '_parent' ? 'selected':''}}>父框架集中</option>
                    <option value="_top" {{$friendlyLink->target == '_top' ? 'selected':''}}>整个窗口中</option>
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">是否展示</label>
            <div class="layui-input-block">
                <input type="checkbox" name="show" value="1" lay-skin="switch" lay-text="展示|隐藏" {{$friendlyLink->show == 1 ? 'checked':''}}>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-block">
                <input type="text" name="order" value="{{$friendlyLink->order}}" placeholder="默认0 顺序从小到大" class="layui-input"/>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="submit" data-url="{{route('friendlyLink@postEdit',['id'=>$friendlyLink->id])}}">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>

@endsection

@section('jsImport')
    @jsimport(friendlyLink/edit)
@endsection