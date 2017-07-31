<?php

if(!function_exists('pagers'))
{
    function pagers($cid){
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