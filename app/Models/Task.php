<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'title', 'description', 'is_completed', 'user_id', 'priority'];

    protected $appends = ['short_description'];

    // Добавляем метод для связи с моделью User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getShortDescriptionAttribute()
    {
        return mb_strimwidth($this->description, 0, 120, '...');
    }
}
