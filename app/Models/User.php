<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function ototubus()
    {
        return $this->hasMany(Ototubu::class);
    }
     
     public function loadRelationshipCounts()
    {
        $this->loadCount('ototubus','followings', 'followers','favorites');
    }
    
      /**
     * このユーザがフォロー中のユーザ。（Userモデルとの関係を定義）
     */
    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }
    
    /**
     * このユーザをフォロー中のユーザ。（Userモデルとの関係を定義）
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }
    
    public function follow($userId)
    {
        $exist = $this->is_following($userId);
        $its_me = $this->id == $userId;
        
        if ($exist || $its_me) {
            return false;
        } else {
            $this->followings()->attach($userId);
            return true;
        }
    }
    
    /**
     * $userIdで指定されたユーザをアンフォローする。
     * 
     * @param  int $usereId
     * @return bool
     */
    public function unfollow($userId)
    {
        $exist = $this->is_following($userId);
        $its_me = $this->id == $userId;
        
        if ($exist && !$its_me) {
            $this->followings()->detach($userId);
            return true;
        } else {
            return false;
        }
    }
    
     public function is_following($userId)
    {
        return $this->followings()->where('follow_id', $userId)->exists();
    }
    
    public function feed_ototubus()
    {
        // このユーザがフォロー中のユーザのidを取得して配列にする
        $userIds = $this->followings()->pluck('users.id')->toArray();
        // それらのユーザが所有する投稿に絞り込む
        return Ototubu::whereIn('user_id', $userIds);
    }
    
    public function favorites(){
        return $this->belongsToMany(Ototubu::class, 'favorites', 'user_id', 'ototubu_id')->withTimestamps();
    }
    
    public function favorite($ototubuId)
    {
        $exist = $this->is_favorite($ototubuId);
        
        if ($exist) {
            return false;
        } else {
            $this->favorites()->attach($ototubuId);
            return true;
        }
    }
    
    public function unfavorite($ototubuId)
    {
        $exist = $this->is_favorite($ototubuId);
        
        if ($exist) {
            $this->favorites()->detach($ototubuId);
            return true;
        } else {
            return false;
        }
    }
    
    public function is_favorite($ototubuId)
    {
        return $this->favorites()->where('ototubu_id', $ototubuId)->exists();
    }
}
