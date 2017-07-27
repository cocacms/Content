<?php
Route::group(['middleware'=>'coca-admin-check'],function (){

    Route::group(['prefix'=>'article'],function (){
        Route::get('/list','ArticleController@_list')->name('article@list')->permissionName('获取文章列表');
        Route::get('/','ArticleController@index')->name('article@index')->link('dictionary@list');

        Route::post('/','ArticleController@postAdd')->name('article@postAdd')->permissionName('创建文章');
        Route::get('/addPage','ArticleController@add')->name('article@add')->link('dictionary@postAdd');

        Route::post('/edit/{id}','ArticleController@postEdit')->name('article@postEdit')->permissionName('编辑文章');
        Route::get('/edit/{id}','ArticleController@edit')->name('article@edit')->link('dictionary@postEdit');

        Route::delete('/','ArticleController@del')->name('article@del')->permissionName('删除文章');

        Route::post('/order','ArticleController@changeOrder')->name('article@changeOrder')->permissionName('修改文章顺序');
        Route::post('/status','ArticleController@changeStatus')->name('article@changeStatus')->permissionName('修改文章状态');
        Route::post('/recommend','ArticleController@changeRecommend')->name('article@changeRecommend')->permissionName('文章推荐');
    },'文章管理');

    Route::group(['prefix'=>'pager'],function (){
        Route::get('/list','PagerController@_list')->name('pager@list')->permissionName('获取页面列表');
        Route::get('/','PagerController@index')->name('pager@index')->link('pager@list');

        Route::post('/','PagerController@postAdd')->name('pager@postAdd')->permissionName('创建页面');
        Route::get('/addPage','PagerController@add')->name('pager@add')->link('pager@postAdd');

        Route::post('/edit/{id}','PagerController@postEdit')->name('pager@postEdit')->permissionName('编辑页面');
        Route::get('/edit/{id}','PagerController@edit')->name('pager@edit')->link('pager@postEdit');

        Route::delete('/','PagerController@del')->name('pager@del')->permissionName('删除页面');

    },'页面管理');


    Route::group(['prefix'=>'friendlyLink'],function (){
        Route::get('/list','FriendlyLinkController@_list')->name('friendlyLink@list')->permissionName('获取友情链接列表');
        Route::get('/','FriendlyLinkController@index')->name('friendlyLink@index')->link('friendlyLink@list');

        Route::post('/','FriendlyLinkController@postAdd')->name('friendlyLink@postAdd')->permissionName('创建友情链接');
        Route::get('/addPage','FriendlyLinkController@add')->name('friendlyLink@add')->link('friendlyLink@postAdd');

        Route::post('/edit/{id}','FriendlyLinkController@postEdit')->name('friendlyLink@postEdit')->permissionName('编辑友情链接');
        Route::get('/edit/{id}','FriendlyLinkController@edit')->name('friendlyLink@edit')->link('friendlyLink@postEdit');

        Route::delete('/','FriendlyLinkController@del')->name('friendlyLink@del')->permissionName('删除友情链接');

        Route::post('/order','FriendlyLinkController@changeOrder')->name('friendlyLink@changeOrder')->permissionName('修改友情链接顺序');
        Route::post('/show','FriendlyLinkController@changeShow')->name('friendlyLink@changeShow')->permissionName('修改友情链接显示隐藏');

    },'友情链接管理');


});


/**
 * function autoPermission 登录用户就有权限
 * function link 展示页面所关联的权限 参数填关联的route的name
 * function permissionName 权限名称
 */