@extends('web.layout')
@section('title', $pager->name.' - 众商平台')
@section('description', $pager->description)
@section('keywords', $pager->keyword)
@section('cssImport')
@endsection
@section('content')

    <div data-am-widget="slider" class="am-slider am-slider-a1" data-am-slider='{}' >
        <ul class="am-slides">
            @foreach(promo($pager->additional['slider_tag']) as $item)
            <li>
                <img src="{{asset($item->pic)}}">
            </li>
            @endforeach

        </ul>
    </div>

    <div class="main-content">
        <div class="am-g products">
            <div class="am-u-sm-12 am-u-md-6 ">
                <div class="item">
                    <div class="pic">
                        <img src="images/product.jpeg"/>
                    </div>
                    <div class="detail">
                        <div>
                            单价：1元
                        </div>
                        <div>
                            数量：<span class="am-icon-plus-square"></span> <span>12</span> <span class="am-icon-minus-square"></span>
                        </div>
                    </div>
                    <div class="buttons">
                        <button type="button" class="am-btn am-btn-default am-radius">加入购物车<span class="am-badge am-badge-danger am-round">6</span></button>
                        <button type="button" class="am-btn am-btn-default am-radius">立即购买</button>
                    </div>
                </div>
            </div>

            <div class="am-u-sm-12 am-u-md-6 ">
                <div class="item">
                    <div class="pic">
                        <img src="images/product.jpeg"/>
                    </div>
                    <div class="detail">
                        <div>
                            单价：1元
                        </div>
                        <div>
                            数量：<span class="am-icon-plus-square"></span> 12 <span class="am-icon-minus-square"></span>
                        </div>
                    </div>
                    <div class="buttons">
                        <button type="button" class="am-btn am-btn-default am-radius">加入购物车</button>
                        <button type="button" class="am-btn am-btn-default am-radius">立即购买</button>
                    </div>
                </div>
            </div>

            <div class="am-u-sm-12 am-u-md-6 ">
                <div class="item">
                    <div class="pic">
                        <img src="images/product.jpeg"/>
                    </div>
                    <div class="detail">
                        <div>
                            单价：1元
                        </div>
                        <div>
                            数量：<span class="am-icon-plus-square"></span> 12 <span class="am-icon-minus-square"></span>
                        </div>
                    </div>
                    <div class="buttons">
                        <button type="button" class="am-btn am-btn-default am-radius">加入购物车</button>
                        <button type="button" class="am-btn am-btn-default am-radius">立即购买</button>
                    </div>
                </div>
            </div>

            <div class="am-u-sm-12 am-u-md-6 ">
                <div class="item">
                    <div class="pic">
                        <img src="images/product.jpeg"/>
                    </div>
                    <div class="detail">
                        <div>
                            单价：1元
                        </div>
                        <div>
                            数量：<span class="am-icon-plus-square"></span> 12 <span class="am-icon-minus-square"></span>
                        </div>
                    </div>
                    <div class="buttons">
                        <button type="button" class="am-btn am-btn-default am-radius">加入购物车</button>
                        <button type="button" class="am-btn am-btn-default am-radius">立即购买</button>
                    </div>
                </div>
            </div>

            <div class="am-u-sm-12 am-u-md-6">
                <div class="item">
                    <div class="pic">
                        <img src="images/product.jpeg"/>
                    </div>
                    <div class="detail">
                        <div>
                            单价：1元
                        </div>
                        <div>
                            数量：<span class="am-icon-plus-square"></span> 12 <span class="am-icon-minus-square"></span>
                        </div>
                    </div>
                    <div class="buttons">
                        <button type="button" class="am-btn am-btn-default am-radius">加入购物车</button>
                        <button type="button" class="am-btn am-btn-default am-radius">立即购买</button>
                    </div>
                </div>
            </div>

            <div class="am-u-sm-12 am-u-md-6 ">
                <div class="item">
                    <div class="pic">
                        <img src="images/product.jpeg"/>
                    </div>
                    <div class="detail">
                        <div>
                            单价：1元
                        </div>
                        <div>
                            数量：<span class="am-icon-plus-square"></span> 12 <span class="am-icon-minus-square"></span>
                        </div>
                    </div>
                    <div class="buttons">
                        <button type="button" class="am-btn am-btn-default am-radius">加入购物车</button>
                        <button type="button" class="am-btn am-btn-default am-radius">立即购买</button>
                    </div>
                </div>
            </div>

        </div>

        <div class="new-products">
            <h2>新品上市</h2>

            <ul class="am-avg-sm-3">

                @foreach(promo($pager->additional['new_tag'],3) as $item)
                    <li>
                        <img src="{{asset($item->pic)}}">
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="about" id="about">
            <h2>关于众商</h2>
            <div class="box">
                <div class="content">
                    {!! $pager->content !!}
                </div>

            </div>

        </div>

    </div>
@endsection

@section('jsImport')
@endsection