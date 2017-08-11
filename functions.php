<?php

if(!function_exists('pagers'))
{
    function pagers_by_id($id){
        $pager =  \Module\Content\Models\Pager::where('id','=',$id)->firstOrFail();
        $pager->template = $pager->template ? $pager->template : 'default';
        $pager->content = base64_decode($pager->content);
        $pager->additional = unserialize($pager->additional);
        return $pager;
    }

    function pagers_by_tag($tag){
        $pager =  \Module\Content\Models\Pager::where('tag','=',$tag)->firstOrFail();
        $pager->template = $pager->template ? $pager->template : 'default';
        $pager->content = base64_decode($pager->content);
        $pager->additional = unserialize($pager->additional);
        return $pager;
    }

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