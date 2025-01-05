<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'active'
    ];


    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    public function concepts():HasMany
    {
        return $this->hasMany(Concept::class, 'category_id', 'id');
    }
}
