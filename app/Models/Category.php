<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    // علاقة التصنيف بالمنتجات
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // توليد slug تلقائيًا عند إنشاء التصنيف
    protected static function booted()
    {
        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });

        // في حال التعديل لاحقًا (اختياري)
        static::updating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }
}
