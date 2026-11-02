<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'code',
        'name',
        'category_id',
        'current_stock',
        'status'
    ];

    public $timestamps = false;

    public function kategori()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
