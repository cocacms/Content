<?php
return [
    'name' => '内容管理模块', //模块名称
    'description' => '文章，单页，友情链接 等', //模块描述
    'author' => 'rojer', //作者
    'auto' => false, //自动开启
    'menu' => [
        [
            "title" => "内容管理",
            "icon" => "coca-icon coca-icon-icon",
            "href" => '',
            "spread" => false,
            "children" => [
                [
                    "title" => "文章管理",
                    "icon" => "coca-icon coca-icon-207",
                    "href" => 'route[article@index]',
                    "spread" => false,
                ],
                [
                    "title" => "单页管理",
                    "icon" => "coca-icon coca-icon-page",
                    "href" => 'route[pager@index]',
                    "spread" => false,
                    "children" => [

                    ]
                ],
                [
                    "title" => "友情链接",
                    "icon" => "coca-icon coca-icon-youqinglianjie2",
                    "href" => 'route[friendlyLink@index]',
                    "spread" => false,
                    "children" => [

                    ]
                ]
            ]
        ],

    ],
    'temp'=>[
    ]
];
