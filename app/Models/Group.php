<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'user_id','ime', 'opis'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function member()
    {
        return $this->hasMany(Member::class);
    }

    public function post()
    {
        return $this->hasMany(Post::class);
    }
    use HasFactory;
}
