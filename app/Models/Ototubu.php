<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ototubu extends Model
{
    use HasFactory;

    protected $fillable = ['music','artist','url','content'];

    /**
     * この投稿を所有するユーザ。（ Userモデルとの関係を定義）
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function favorite_users(){
         return $this->belongsToMany(User::class, 'favorites', 'ototubu_id', 'user_id')->withTimestamps();
    }
}
