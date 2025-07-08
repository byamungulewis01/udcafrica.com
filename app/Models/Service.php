<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'icon',
        'order',
        'is_active',
        'created_by',
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
            $model->order = Service::max('order') + 1;
        });
    }

}
