@extends('web.layout')
@section('title')
    {{$pager->title or $pager->name . ' - '.system_config('webname')}}
@endsection
@section('description', $pager->description)
@section('keywords', $pager->keyword)
@section('cssImport')
@endsection
@section('content')

    <div class="main-content products-list">
        @php
            $defaultCategory = \Module\AdminBase\Models\Category::where('tag', '=', 'product')->firstOrFail()->getDescendantsAndSelf()->toHierarchy()->first();
            $rootId = $defaultCategory->id;
            $selectId = request()->input('category',$rootId);

            $selectCategory = \Module\AdminBase\Models\Category::where('id', '=', $selectId)->firstOrFail();

            function product_category_tree_build_fun($trees,$selectCategory){
                $html = '';

                $pop = '<ul class="pop">';
                foreach ($trees as $tree){
                    $link = route('pager@showByTag',['tag'=>'product-list','category'=>$tree->id]);
                    if($tree->isAncestorOf($selectCategory)){
                        $pop.= "<li class=\"current\"><a href=\"$link\">· $tree->name</a></li>";
                    }else{
                        $pop.= "<li ><a href=\"$link\">· $tree->name</a></li>";
                    }
                }
                $pop .= '</ul>';


                foreach ($trees as $tree){
                    if($tree->isSelfOrAncestorOf($selectCategory)){
                        $css = "";
                        if($tree->id == $selectCategory->id){
                            $css = "am-active";

                        }
                        if($tree->children->count() > 0){
                            $css .= " toggle";
                        }
                        $html.= "<li class=\"$css\"><a href=\"#\">$tree->name</a>$pop</li>";
                        if($tree->children && $tree->children->count() > 0){
                            $html.= product_category_tree_build_fun($tree->children,$selectCategory);
                        }
                        return $html;
                    }
                    if($selectCategory->depth + 1 == $tree->depth){
                        $html.= "<li class=\"am-active toggle\"><a href=\"#\">更多</a>$pop</li>";
                        return $html;
                    }

                }


            }
            $products = products_list($selectCategory->id);
        @endphp

        <ol class="am-breadcrumb">
            <li><a href="{{route('pager@home')}}">首页</a></li>
            <li><a href="{{route('pager@showByTag',['tag'=>'product-list'])}}">产品分类</a></li>
            {!! product_category_tree_build_fun($defaultCategory->children,$selectCategory) !!}

        </ol>


        <div class="am-g products">

            @if($products->count() == 0)
                <p style="text-align: center">暂无产品！</p>
            @endif

            @foreach($products as $item)
                <div class="am-u-sm-12 am-u-md-6" >
                    <div class="item">
                        <a href="{{route('product@web@detail',['id'=>$item->id])}}" title="{{$item->name}}">
                        <div class="pic">
                            <img src="{{asset($item->pic)}}"/>
                        </div>
                        </a>
                        <div class="detail">
                            <div class="title" title="{{$item->name}}">
                                {{$item->name}}
                            </div>
                            <div class="price">
                                ￥{{number_format($item->price,2)}}
                            </div>

                            <div class="no-select">
                                数量：<span data-src="{{route('cart@minus',['pid'=>$item->id])}}" class="cart-action am-icon-minus-square"></span>
                                <span class="cart-count" data-pid="{{$item->id}}">{{cart_product_count($item->id)}}</span>
                                <span class="cart-action am-icon-plus-square"  data-src="{{route('cart@plus',['pid'=>$item->id])}}"></span>
                            </div>
                        </div>

                        <div class="buttons">
                            <button type="button" class="am-btn am-btn-default am-radius cart_add_btn">加入购物车
                                @if(cart_product_count($item->id) > 0)
                                    <span class="am-badge am-badge-danger am-round">{{cart_product_count($item->id)}}</span>
                                @endif
                            </button>
                            <button type="button" data-src="{{route('order@create')}}" class="am-btn am-btn-default am-radius cart_buy_btn">立即购买</button>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        {{$products->appends(['category' => $selectId])->links()}}

    </div>

@endsection

@section('jsImport')
    @import(js/cart,js,Shop)
@endsection