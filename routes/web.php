<?php
Route::group(['middleware'=>'web'],function (){
    Route::get('/','PagerController@show')->name('pager@home');
    Route::group(['prefix'=>'pager'],function (){
        Route::get('/{tag}','PagerController@show')->name('pager@show');
    });

    Route::group(['prefix'=>'article'],function (){
        Route::get('/{ids?}','ArticleWebController@_list')->name('article@web@list');
        Route::get('/detail/{id}','ArticleWebController@detail')->name('article@web@detail');
    });
});


/**
 * function autoPermission 登录用户就有权限
 * function link 展示页面所关联的权限 参数填关联的route的name
 * function permissionName 权限名称
 */