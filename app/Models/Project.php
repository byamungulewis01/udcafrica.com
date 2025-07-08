<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'featured_image',
        'client',
        'year_of_completion',
        'location',
        'architect',
        'size',
        'gallery',
        'is_featured',
        'is_published',
        'order',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'category_id',
        'created_by'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'gallery' => 'array',
    ];

    protected $appends = [
        'reading_time',
        'formatted_published_at',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = Auth::id();
            $model->order = Project::max('order') + 1;
        });
    }

    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }

    public function getFormattedPublishedAtAttribute()
    {
        return $this->created_at->format('d M Y');
    }

    public function getReadingTimeAttribute()
    {
        $words = str_word_count(strip_tags($this->content));
        return ceil($words / 200);
    }
}
