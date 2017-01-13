<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'url'
    ];
    protected $appends = ['like_count', 'dislike_count'];

    public function post()
    {
        return $this->belongsToMany('App\Post', 'image_posts')->withTimestamps();
    }

    public static function getAvatarPath($avatar)
    {
        $path = '/upload/avatars/';
        $fileName = str_random(8) . $avatar->getClientOriginalName();
        $fullPath = public_path() . $path;
        $avatar->move($fullPath, $fileName);
        return $path . $fileName;
    }

    public static function getPostPath($image)
    {
        $path = '/upload/post/';
        $fileName = str_random(8) . $image->getClientOriginalName();
        $fullPath = public_path() . $path;
        $image->move($fullPath, $fileName);
        return $path . $fileName;
    }

    public static function getDashboardPath($image)
    {
        $path = '/upload/dashboard/';
        $fileName = str_random(8) . $image->getClientOriginalName();
        $fullPath = public_path() . $path;
        $image->move($fullPath, $fileName);
        return $path . $fileName;
    }

    public static function getPhotoPath($image)
    {
        $path = '/upload/photo/';
        $fileName = str_random(8) . $image->getClientOriginalName();
        $fullPath = public_path() . $path;
        $image->move($fullPath, $fileName);
        return $path . $fileName;
    }

    public function comments() {
        return $this->belongsToMany(NormalComment::class, 'image_comments')->orderBy('created_at', 'DESC');
    }

    public function likes() {
        return $this->belongsToMany(Like::class, 'image_likes')->where('like/dislike', 1);
    }

    public function likers() {
        return $this->belongsToMany(Like::class, 'image_likes')->where('like/dislike', 1)->take(6);
    }

    public function getLikeCountAttribute() {
        return $this->likes()->count();
    }

    public function disLikes() {
        return $this->belongsToMany(Like::class, 'image_likes')->where('like/dislike', 0);
    }

    public function disLikers() {
        return $this->belongsToMany(Like::class, 'image_likes')->where('like/dislike', 0)->take(6);
    }

    public function getDislikeCountAttribute() {
        return $this->disLikes()->count();
    }

    public function album() {
        return $this->belongsToMany(Album::class, 'album_images');
    }
}
