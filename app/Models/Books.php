<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
    {
    use HasFactory;
    protected $table = "books";

    protected $fillable = ["name", "author", "publish_date", "user_id"];

    public function user()
        {
        return $this->belongsTo(User::class, 'user_id');
        }
    }
