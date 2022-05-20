<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getImageAttribute($image)
    {
        return asset('storage/posts/' . $image);
    }

    public function getCratedAtAttribute($date)
    {
        return Carbon::parse($data)->format('d-M-Y');
    }
}
