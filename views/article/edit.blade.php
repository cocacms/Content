@extends('layout.layout')
@section('title', '添加')
@section('cssImport')
    @cssimport(article)
@endsection

@section('content')
    <form class="layui-form" style="width: 80%;">

        <div class="layui-form-item">
            <label class="layui-form-label">分类</label>
            <div class="layui-input-block">

                <select class="layui-input" lay-filter="category">
                    @foreach($category as $item)
                        <option value="{{$item['id']}}" data-name="{{$item['tname']}}">{{$item['name']}}</option>
                    @endforeach
                </select>

                <div class="category-tags">

                    @foreach($article->categories as $category)
                        <div class="category-tag">
                            <span class="layui-btn layui-btn-mini layui-btn-radius btn-tag">{{$category->name}}</span>
                            <i class="layui-icon remove_category_tag">&#x1007;</i>
                            <input type="hidden" name="categories[]" value="{{$category->id}}"/>
                        </div>
                    @endforeach

                </div>

            </div>
        </div>


        <div class="layui-form-item">
            <label class="layui-form-label">标题</label>
            <div class="layui-input-block">
                <input type="text" name="title" value="{{$article->title}}" placeholder="请输入名称" lay-verify="required" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">SEO关键字</label>
            <div class="layui-input-block">
                <input type="text" name="keyword" value="{{$article->keyword}}" placeholder="请输入SEO关键字" autocomplete="false" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">文章来源</label>
            <div class="layui-input-block">
                <input type="text" name="source" value="{{$article->source}}" placeholder="请输入文章来源" autocomplete="false" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">文章作者</label>
            <div class="layui-input-block">
                <input type="text" name="author" value="{{$article->author}}" placeholder="请输入文章作者" autocomplete="false" class="layui-input">
            </div>
        </div>


        <div class="layui-form-item">
            <label class="layui-form-label">封面</label>
            <div class="layui-input-block">
                <img src="{{asset($article->pic)}}" id="file" height="120px">
                <br/><br/>
                <input type="file" name="file" class="layui-upload-file" lay-title="更换图片">
                <input type="hidden" name="pic" value="{{$article->pic}}">
            </div>

        </div>

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">摘要</label>
            <div class="layui-input-block">
                <textarea name="excerpt" placeholder="请输入摘要" class="layui-textarea">{{$article->excerpt}}</textarea>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">内容</label>
            <div class="layui-input-block">
                <textarea id="content" name="content" style="display: none;">{{$article->content}}</textarea>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <select name="status">
                    <option value="0" {{$article->status == 0 ? 'selected':''}}>正常显示</option>
                    <option value="1" {{$article->status == 1 ? 'selected':''}}>隐藏文章</option>
                    <option value="2" {{$article->status == 2 ? 'selected':''}}>首页显示</option>
                </select>
            </div>
        </div>


        <div class="layui-form-item">
            <label class="layui-form-label">是否推荐</label>
            <div class="layui-input-block">
                <input type="checkbox" name="recommended" value="1" lay-skin="switch" lay-text="推荐|推荐" {{$article->recommended == 1 ? 'checked':''}}>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-block">
                <input type="text" name="order" value="{{$article->order}}" placeholder="默认0 顺序从小到大" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">点击量</label>
            <div class="layui-input-block">
                <input type="text" name="click_count" value="{{$article->click_count}}" placeholder="默认0 顺序从小到大" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">发布时间</label>
            <div class="layui-input-block">
                <input type="text" name="push_time" value="{{$article->push_time}}" placeholder="请输入发布时间" onclick="layui.laydate({elem: this,max: laydate.now(),format: 'YYYY-MM-DD hh:mm:ss',istime: true})" class="layui-input ">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="submit" data-url="{{route('article@postEdit',['id'=>$article->id])}}">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>

    <script type="text/html" id="tag_template">
        <div class="category-tag">
            <span class="layui-btn layui-btn-mini layui-btn-radius btn-tag"></span>
            <i class="layui-icon remove_category_tag">&#x1007;</i>
            <input type="hidden" name="categories[]" value=""/>
        </div>
    </script>

@endsection

@section('jsImport')
    @jsimport(article/edit)
@endsection