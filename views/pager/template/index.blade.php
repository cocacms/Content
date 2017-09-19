@extends('web.layout')
@section('title', $pager->name.' - '.system_config('webname'))
@section('description', $pager->description)
@section('keywords', $pager->keyword)
@section('cssImport')
@endsection
@section('content')

    <div data-am-widget="slider" class="am-slider am-slider-a1" data-am-slider='{}' >
        <ul class="am-slides">
            @foreach(promo($pager->additional['slider_tag']) as $item)
            <li>
                <a href="{{route_parse($item->link)}}" target="{{$item->target}}">
                    <img src="{{asset($item->pic)}}"/>
                </a>
            </li>
            @endforeach

        </ul>
    </div>

    <div class="main-content">
        <h2>产品推荐</h2>
        <div class="am-g products">

            @foreach(recommended_products() as $item)
                @if($item->show == 1)
                <div class="am-u-sm-12 am-u-md-6">
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
                                {{--<span class="cart-count" data-pid="{{$item->id}}">{{cart_product_count($item->id)}}</span>--}}
                                <input style="text-align: center;width: 50px;" data-src="{{route('cart@adjust',['pid'=>$item->id,'count'=>''])}}" data-pid="{{$item->id}}" type="text" name="data[{{$item->id}}]" value="{{cart_product_count($item->id)}}" class="number" onKeyUp="this.value=this.value.replace(/[^\d]/g,'');">
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
                @endif
            @endforeach

        </div>

        <div class="new-products">
            <h2>新品上市</h2>

            <ul class="am-avg-sm-3">

                @foreach(promo($pager->additional['new_tag']) as $item)
                    <li>
                        <a href="{{route_parse($item->link)}}" target="{{$item->target}}">
                            <img src="{{asset($item->pic)}}">
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="about" id="about">
            <h2>关于{{system_config('webname')}}</h2>
            <div class="box">
                <div class="content">
                    {!! $pager->content !!}
                </div>

            </div>

        </div>

    </div>
@endsection

@section('jsImport')
    @import(js/cart,js,Shop)
@endsection