<?php

namespace Module\Content\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    /**
     * 需要被转换成日期的属性。
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    const STATUS_NORMAL = 0;
    const STATUS_HIDE = 1;
    const STATUS_PUSH_INDEX = 2;

    protected $fillable = ['title','keyword','source','excerpt','content','recommended','order','status','push_time','pic','click_count','author','member_id'];

    public function categories(){
        return $this->belongsToMany(
            'Module\AdminBase\Models\Category',
            'article_categories',
            'article_id',
            'category_id'
        );
    }

    public function member()
    {
        return $this->belongsTo('Module\AdminBase\Models\Member');
    }

}
