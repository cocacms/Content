<?php

namespace Module\Content\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    public function articles()
    {
        return $this->hasMany('Module\Content\Models\Article','id','article_id');
    }
}
