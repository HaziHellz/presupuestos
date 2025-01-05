<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteDetail extends Model
{
    protected $table = 'quotes_details';

    protected $fillable = [
        'quantity',
        'registered_price',
        'quote_id',
        'concept_id'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'registered_price' => 'double'
    ];


    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class, 'quote_id', 'id');
    }

    public function concept(): BelongsTo
    {
        return $this->belongsTo(Concept::class, 'concept_id', 'id');
    }
}
