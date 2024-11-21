<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'title',
        'user_id'
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }
    public function tag()
    {
        $this->belongsToMany(Tag::class,'post_tag');
    }
}
