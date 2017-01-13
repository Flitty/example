<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Group extends Model
{
    protected $fillable = ['title', 'url', 'description', 'web_site', 'min_age', 'wall_type', 'photo_type', 'video_type',
        'is_closed', 'theme_id', 'city_id', 'comment_type', 'discussion_type', 'avatar_id','is_only_offer','social_rating','subtitle','statistics','is_proposed_post'];

    protected $with = ['avatar','theme'];

    protected $appends = ['role', 'user_count', 'subscriber', 'post_count'];

    public function city()
    {
        return $this->belongsTo(City::class)->with('country');
    }

    public function theme()
    {
        return $this->belongsTo(GroupTheme::class);
    }

    public function games()
    {
        return $this->belongsToMany(Game::class, 'group_games');
    }

    public function users()
    {
        return $this->hasMany('App\GroupUser')->with(['role', 'user.image'])->where('is_confirmed', true);
    }

    public function videos()
    {
        return $this->belongsToMany('App\Video', 'group_videos')->withTimestamps();
    }

    public function subscribers()
    {
        return $this->hasMany('App\GroupUser')->with(['role', 'user.image'])->where('is_confirmed', false);
    }

    public function admin()
    {
        $roleId = Role::firstOrCreate(['name' => 'player'])->id;
        return $this->hasMany('App\GroupUser')->with(['role', 'user.image'])->where('role_id', '!=', $roleId);
    }

    public function block()
    {
        return $this->hasMany('App\GroupBlockUser')->with(['user.image']);
    }

//    public function users()
//    {
//        return $this->belongsToMany(User::class, 'group_users')->withPivot('role_id','is_confirmed')->with('image')->where('is_confirmed',true);
//    }

//    public function subscribers()
//    {
//        return $this->belongsToMany(User::class, 'group_users')->withPivot('role_id','is_confirmed')->with('image')->where('is_confirmed',false);
//    }

    public function post()
    {
        return $this->belongsToMany('App\Post', 'group_posts')->wherePivot('is_offer', 0);
    }

    public function offerPost()
    {
        return $this->belongsToMany('App\Post', 'group_posts')->wherePivot('is_offer', 1)->withPivot('is_offer');
    }

    public function link()
    {
        return $this->belongsToMany('App\Link', 'group_links');
    }

    public function avatar()
    {
        return $this->belongsTo('App\Image', 'avatar_id');
    }

//    public function groupUser()
//    {
//        return $this->belongsTo('App\GroupUser', 'group_id')->with('role');
//    }

    public function getRoleAttribute()
    {
        $user = $this->users()->where('user_id', Auth::id())->first();
        $role = null;
        if ($user) {
            $role = Role::find($user->role_id)->name;
        }
        return $role;
    }

    public function getSubscriberAttribute()
    {
        $user = $this->subscribers()->where('user_id', Auth::id())->first();
        $subscriber = false;
        if ($user) {
            $subscriber = true;
        }
        return $subscriber;
    }

    public function getUserCountAttribute()
    {
        return $this->users()->count();
    }

    public function getPostCountAttribute() {
        return $this->belongsToMany('App\Post', 'group_posts')->wherePivot('is_offer', 0)->count();
    }


    public function groupAlbums() {
        return $this->belongsToMany('App\Album', 'group_albums');
    }

//    public function () {
//
//    }
//    public function getAttribute() {
//
//    }


}
