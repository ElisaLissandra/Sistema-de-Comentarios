<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'commentable_id',
        'commentable_type',
        'user_id',
        'text_comment',
    ];

    public function commentable()
    {
        return $this->morphTo();
    } 

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
