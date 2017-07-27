<?php

namespace Module\Content\Models;

use Illuminate\Database\Eloquent\Model;

class FriendlyLink extends Model
{
    protected $fillable = ['tag','name','link','show','order'];
}
