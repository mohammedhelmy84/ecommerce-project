<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = "cities";  
    protected $fillable = ['name', 'governorate_id'];
    protected $casts = [
        'name' => 'array',
    ];

    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }
}
