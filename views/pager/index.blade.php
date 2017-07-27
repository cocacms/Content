@extends('layout.layout')
@section('title', '管理')

@section('content')
    <blockquote class="layui-elem-quote">
        @canshow(pager@add)
        <div class="layui-inline">
            <a class="layui-btn add_btn" style="background-color:#5FB878" data-url="{{route('pager@add')}}">添加页面</a>
        </div>
        @endcanshow
        @canshow(pager@del)
        <div class="layui-inline">
            <a class="layui-btn layui-btn-danger batch_del" data-url="{{route('pager@del')}}">批量删除</a>
        </div>
        @endcanshow
        <div class="clear-float"></div>
    </blockquote>
    <div class="layui-form table_list">
        <table id="table" class="layui-table" data-url="{{route('pager@list')}}">
            <colgroup>
                <col width="50"/>
                <col width="5%"/>
                <col width="15%"/>
                <col width="10%"/>
                <col width="55%"/>
                <col width="15%"/>
            </colgroup>
            <thead>
            <tr>
                <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose"></th>
                <th style="text-align:left;">ID</th>
                <th>名称</th>
                <th>标识</th>
                <th>内容摘要</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody class="table_content"></tbody>
        </table>
    </div>
    <div id="page"></div>

    <script id="table-tpl" type="text/html">
        @{{#  layui.each(d, function(index, item){ }}
        <tr>
            <td><input type="checkbox" name="checked" lay-skin="primary" lay-filter="choose"></td>
            <td align="left">@{{ item.id }}</td>
            <td>@{{ item.name }}</td>
            <td>@{{ item.tag }}</td>
            <td>@{{ item.content }}</td>
            <td>
                @canshow(pager@edit)
                <a class="layui-btn layui-btn-mini edit_btn" data-id="@{{ item.id }}" data-url="{{route('pager@edit',['id'=>''])}}"><i class="iconfont icon-edit"></i> 编辑</a>
                @endcanshow
                @canshow(pager@del)
                <a class="layui-btn layui-btn-danger layui-btn-mini del_btn" data-id="@{{ item.id }}" data-url="{{route('pager@del')}}"><i class="layui-icon">&#xe640;</i> 删除</a>
                @endcanshow
            </td>
        </tr>

        @{{#  }); }}

        @{{#  if(d.length === 0){ }}
        <tr><td colspan="6">暂无数据</td></tr>
        @{{#  } }}
    </script>

@endsection

@section('jsImport')
    @jsimport(pager/index)
@endsection