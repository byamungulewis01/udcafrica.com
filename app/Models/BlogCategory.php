<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    //
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
}
