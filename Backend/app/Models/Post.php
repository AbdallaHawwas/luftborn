<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    // The attributes should be filled and returned
    public $fillable = [
        "title",
        "content",
        "user_id",
        "category_id"
    ];

    public $hidden = ["user_id"];
    // The relation method to refer posts to users
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
   
    // The relation method to refer posts to categories
    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Get Post Comments
    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
