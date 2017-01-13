<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    protected $fillable = ['group_id', 'user_id', 'role_id', 'is_confirmed'];
    protected $appends = ['is_block'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getIsBlockAttribute()
    {
        $isBlock = GroupBlockUser::where('group_id',$this->group_id)
            ->where('user_id',$this->user_id)
            ->where('unlock_time','>',Carbon::now())
            ->first();
        if ($isBlock){
            return true;
        }
    }
}
