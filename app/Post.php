<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title','body','pic_id','user_id'];

    public function pic()
    {
        return $this->belongsTo(Pic::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class,'post_categories');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }






}
