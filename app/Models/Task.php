<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'title', 'description', 'is_completed', 'user_id'];

    protected $appends = ['short_description'];

    public function getShortDescriptionAttribute()
    {
        return mb_strimwidth($this->description, 0, 55, '...');   
    }
}
