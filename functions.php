<?php

if(!function_exists('pagers_by_id')) {
    function pagers_by_id($id)
    {
        $pager = \Module\Content\Models\Pager::where('id', '=', $id)->firstOrFail();
        $pager->template = $pager->template ? $pager->template : 'default';
        $pager->content = base64_decode($pager->content);
        $pager->additional = unserialize($pager->additional);
        return $pager;
    }

}
if(!function_exists('pagers_by_tag')){

    function pagers_by_tag($tag){
        $pager =  \Module\Content\Models\Pager::where('tag','=',$tag)->firstOrFail();
        $pager->template = $pager->template ? $pager->template : 'default';
        $pager->content = base64_decode($pager->content);
        $pager->additional = unserialize($pager->additional);
        return $pager;
    }
}


if(!function_exists('pagers_by_category_ids')){
    function pagers_by_category_ids($cid){
        return \Module\Content\Models\Pager::whereIn('category_id',$cid)
            ->orderByRaw('field(category_id,'.implode(',',$cid).')')
            ->get()->map(function($pager){
            $pager->template = $pager->template ? $pager->template : 'default';
            $pager->content = base64_decode($pager->content);
            $pager->additional = unserialize($pager->additional);
            return $pager;
        });

    }
}

if(!function_exists('pagers_is_current')) {
    function pagers_is_current($pager)
    {
        $id = \Illuminate\Support\Facades\Session::get('_current_page_', null);
        if (!isset($pager->id)) {
            return false;
        }
        if ($id == $pager->id) {
            return true;
        } else {
            return false;
        }
    }
}

if(!function_exists('pagers_set_current')) {
    function pagers_set_current($pager){
        if(isset($pager->id)){
            \Illuminate\Support\Facades\Session::put('_current_page_', $pager->id);
        }else{
            \Illuminate\Support\Facades\Session::forget('_current_page_');
        }
    }
}