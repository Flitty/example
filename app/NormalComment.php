<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NormalComment extends Model
{
    protected $table = 'normal_comments';
    protected $fillable = ['user_id', 'text'];
    protected $appends = ['like_count', 'dislike_count'];

    public function userInfo() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function likes() {
        return $this->belongsToMany(Like::class, 'normal_comment_likes')->where('like/dislike', 1);
    }

    public function likers() {
        return $this->belongsToMany(Like::class, 'normal_comment_likes')->where('like/dislike', 1)->take(6);
    }

    public function getLikeCountAttribute() {
        return $this->likes()->count();
    }

    public function disLikes() {
        return $this->belongsToMany(Like::class, 'normal_comment_likes')->where('like/dislike', 0);
    }

    public function disLikers() {
        return $this->belongsToMany(Like::class, 'normal_comment_likes')->where('like/dislike', 0)->take(6);
    }

    public function getDislikeCountAttribute() {
        return $this->disLikes()->count();
    }
}
