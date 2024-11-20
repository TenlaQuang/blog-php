<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
class Post extends Model
{
    use HasFactory, Notifiable;
   

    protected $fillable = ['content', 'image', 'user_id', 'likes'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }
    public function images()
    {
        return $this->hasMany(PostImage::class);
    }

}
