<?php

// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
    {
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'image',
        'user_id', // Add user_id to the fillable property
    ];

    // Define the relationship between Product and User
    public function user()
        {
        return $this->belongsTo(User::class); // Each product belongs to one user
        }
    }
