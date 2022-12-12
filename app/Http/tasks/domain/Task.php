<?php

namespace App\Http\tasks\domain;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Http\comments\domain\Comment;
use App\Http\files\domain\File;

class Task extends Model
{

    protected $table = 'tasks';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'task_id');
    }
    public function files(): HasMany
    {
        return $this->hasMany(File::class, 'task_id');
    }
}
