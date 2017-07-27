@extends('layout.layout')
@section('title', '管理')

@section('content')
    <blockquote class="layui-elem-quote layui-form">
        <div class="layui-inline">
            分类
        </div>
        <div class="layui-inline">
            <select id="category" lay-filter="chooseCategory" data-id="{{array_keys($category->content)[0]}}">
                @foreach($category->content as $k => $v)
                    <option value="{{$k}}">{{$v}}</option>
                @endforeach
            </select>
        </div>

        @canshow(friendlyLink@add)
        <div class="layui-inline">
            <a class="layui-btn add_btn" style="background-color:#5FB878" data-url="{{route('friendlyLink@add')}}">添加友情链接</a>
        </div>
        @endcanshow
        @canshow(friendlyLink@del)
        <div class="layui-inline">
            <a class="layui-btn layui-btn-danger batch_del" data-url="{{route('friendlyLink@del')}}">批量删除</a>
        </div>
        @endcanshow
        <div class="clear-float"></div>
    </blockquote>
    <form class="layui-form table_list">
        <table id="table" class="layui-table" data-url="{{route('friendlyLink@list')}}">
            <colgroup>
                <col width="50"/>
                <col width="80"/>
                <col width="15%"/>
                <col width="35%"/>
                <col width="80"/>
                <col width="80"/>
                <col width="15%"/>
            </colgroup>
            <thead>
            <tr>
                <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose"></th>
                <th style="text-align:left;">ID</th>
                <th>名称</th>
                <th>链接</th>
                <th>状态</th>
                <th>排序
                    @canshow(friendlyLink@changeOrder)
                    <button class="layui-btn layui-btn-mini" lay-submit="" lay-filter="submit" data-url="{{route('friendlyLink@changeOrder')}}">
                        <i class="coca-icon coca-icon-queren1" ></i>
                    </button>
                    @endcanshow
                </th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody class="table_content"></tbody>
        </table>
    </form>
    <div id="page"></div>

    <script id="table-tpl" type="text/html">
        @{{#  layui.each(d, function(index, item){ }}
        <tr>
            <td><input type="checkbox" name="checked" lay-skin="primary" lay-filter="choose"></td>
            <td align="left">@{{ item.id }}</td>
            <td>@{{ item.name }}</td>
            <td>@{{ item.link }}</td>
            <td>
                @canshow(friendlyLink@changeShow)
                    @{{# if(item.show == 1){ }}
                        <input type="checkbox"
                               data-id="@{{ item.id }}"
                               lay-skin="switch"
                               value="1"
                               lay-text="显示|隐藏" checked
                               lay-filter="switchShow"
                               data-url="{{route('friendlyLink@changeShow')}}"
                               checked
                        >
                    @{{# }else{ }}
                        <input
                                type="checkbox"
                                data-id="@{{ item.id }}"
                                lay-skin="switch"
                                value="1"
                                lay-text="显示|隐藏"
                                lay-filter="switchShow"
                                data-url="{{route('friendlyLink@changeShow')}}"
                        >
                    @{{# } }}
                @else
                    @{{# if(item.show == 1){ }}
                    显示
                    @{{# }else{ }}
                    隐藏
                    @{{# } }}
                @endcanshow
            </td>

            <td>
                @canshow(friendlyLink@changeOrder)
                    <input type="number" class="layui-input" name="order[@{{ item.id }}]" data-id="@{{ item.id }}" data-origin="@{{ item.order }}" value="@{{ item.order }}">
                @else
                    @{{ item.order }}
                @endcanshow
            </td>

            <td>
                @canshow(friendlyLink@edit)
                <a class="layui-btn layui-btn-mini edit_btn" data-id="@{{ item.id }}" data-url="{{route('friendlyLink@edit',['id'=>''])}}"><i class="iconfont icon-edit"></i> 编辑</a>
                @endcanshow
                @canshow(friendlyLink@del)
                <a class="layui-btn layui-btn-danger layui-btn-mini del_btn" data-id="@{{ item.id }}" data-url="{{route('friendlyLink@del')}}"><i class="layui-icon">&#xe640;</i> 删除</a>
                @endcanshow
            </td>
        </tr>

        @{{#  }); }}

        @{{#  if(d.length === 0){ }}
        <tr><td colspan="7">暂无数据</td></tr>
        @{{#  } }}
    </script>

@endsection

@section('jsImport')
    @jsimport(friendlyLink/index)
@endsection