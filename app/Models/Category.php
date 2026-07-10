<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'icon', 'image', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    // Auto generate slug
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }
}