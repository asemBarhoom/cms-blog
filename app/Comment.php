<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['post_id','user_id','body','parent_id'];

    public function post()
    {
        return $this->belongsTo(Post::class,'post_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class,'parent_id','id');
    }


}
