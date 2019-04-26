<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pic extends Model
{
   protected $fillable = ['path'];

   public function user()
   {
       return $this->belongsTo(Post::class );
   }

   public function posts()
   {
       return $this->belongsTo(Post::class);
   }
}
