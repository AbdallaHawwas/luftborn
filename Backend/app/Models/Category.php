<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    // The attributes should be filled and returned
    public $fillable = [
        "title",
        "created_by"
    ];

    // The relation method to get category posts
    public function posts() : HasMany
    {
        return $this->hasMany(Post::class);
    }
}
