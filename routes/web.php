<?php
Route::group(['middleware'=>'web'],function (){
    Route::get('/','PagerController@web_index')->name('pager@home');
    Route::group(['prefix'=>'pager'],function (){
        Route::get('/tag/{tag}','PagerController@showByTag')->name('pager@showByTag');
        Route::get('/{id}','PagerController@showById')->name('pager@showById');
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