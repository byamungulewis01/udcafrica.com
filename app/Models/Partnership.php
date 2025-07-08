<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Partnership extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
        'image',
        'order',
        'is_active',
        'created_by'
    ];
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];


    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = Auth::id();
            $model->order = Partnership::max('order') + 1;
        });
    }
}
