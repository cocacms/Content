@extends('layout.layout')
@section('title', '管理')

@section('content')
    <blockquote class="layui-elem-quote layui-form">
        <div class="layui-inline">
            分类
        </div>
        <div class="layui-inline">
            <select id="category" lay-filter="chooseCategory" data-id="{{$category[0]['id']}}">
                @foreach($category as $item)
                    <option value="{{$item['id']}}">{{$item['name']}}</option>
                @endforeach
            </select>
        </div>

        @canshow(article@add)
        <div class="layui-inline">
            <a class="layui-btn add_btn" style="background-color:#5FB878" data-url="{{route('article@add')}}">添加文章</a>
        </div>
        @endcanshow
        @canshow(article@del)
        <div class="layui-inline">
            <a class="layui-btn layui-btn-danger batch_del" data-url="{{route('article@del')}}">批量删除</a>
        </div>
        @endcanshow
        <div class="clear-float"></div>
    </blockquote>
    <form class="layui-form table_list">
        <table id="table" class="layui-table" data-url="{{route('article@list')}}">
            <colgroup>
                <col width="50"/>
                <col width="5%"/>
                <col width="25%"/>
                <col width="8%"/>
                <col width="80"/>
                <col width="80"/>
                <col width="100"/>
                <col width="100"/>
                <col width="100"/>
                <col width="15%"/>
            </colgroup>
            <thead>
            <tr>
                <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose"></th>
                <th style="text-align:left;">ID</th>
                <th>标题</th>
                <th>编辑者</th>
                <th>点击</th>
                <th>评论</th>
                <th>状态</th>
                <th>推荐</th>
                <th>排序
                    @canshow(article@changeOrder)
                    <button class="layui-btn layui-btn-mini" lay-submit="" lay-filter="submit" data-url="{{route('article@changeOrder')}}">
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
            <td>@{{ item.title }}</td>
            <td>@{{ item.username }}</td>
            <td>@{{ item.click_count }}</td>
            <td>@{{ item.comment_count }}</td>
            <td>
                @{{# if(item.status == 0){ }}
                正常
                @{{# }else if(item.status == 1){ }}
                隐藏
                @{{# }else if(item.status == 2){ }}
                首页显示
                @{{# } }}

            </td>

            <td>
                @canshow(article@changeRecommend)
                    @{{# if(item.recommended == 1){ }}
                        <input type="checkbox"
                               data-id="@{{ item.id }}"
                               lay-skin="switch"
                               value="1"
                               lay-text="推荐|推荐"
                               checked
                               lay-filter="recommend"
                               data-url="{{route('article@changeRecommend')}}"
                        >
                    @{{# }else{ }}
                        <input
                                type="checkbox"
                                data-id="@{{ item.id }}"
                                lay-skin="switch"
                                value="1"
                                lay-text="推荐|推荐"
                                lay-filter="recommend"
                                data-url="{{route('article@changeRecommend')}}"
                        >
                    @{{# } }}
                @else
                    @{{# if(item.recommended == 1){ }}
                    已推荐
                    @{{# }else{ }}
                    未推荐
                    @{{# } }}
                @endcanshow
            </td>

            <td>
                @canshow(article@changeOrder)
                    <input type="number" class="layui-input" name="order[@{{ item.id }}]" data-id="@{{ item.id }}" data-origin="@{{ item.order }}" value="@{{ item.order }}">
                @else
                    @{{ item.order }}
                @endcanshow
            </td>

            <td>
                @canshow(article@edit)
                <a class="layui-btn layui-btn-mini edit_btn" data-id="@{{ item.id }}" data-url="{{route('article@edit',['id'=>''])}}"><i class="iconfont icon-edit"></i> 编辑</a>
                @endcanshow
                @canshow(article@del)
                <a class="layui-btn layui-btn-danger layui-btn-mini del_btn" data-id="@{{ item.id }}" data-url="{{route('article@del')}}"><i class="layui-icon">&#xe640;</i> 删除</a>
                @endcanshow
            </td>
        </tr>

        @{{#  }); }}

        @{{#  if(d.length === 0){ }}
        <tr><td colspan="10">暂无数据</td></tr>
        @{{#  } }}
    </script>

@endsection

@section('jsImport')
    @jsimport(article/index)
@endsection