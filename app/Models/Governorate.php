<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    protected $table = "governorates";
    protected $fillable = ['name'];

    protected $casts = [
        'name' => 'array',
    ];

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
