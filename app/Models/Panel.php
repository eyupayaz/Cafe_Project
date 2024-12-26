<?php

namespace App\Models;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Panel extends Model
{
    protected $table = 'panels';

    protected $fillable = [
        'id',
        'user_id',
        'title',
        'content',
    ];

    public function user()
{
    return $this->hasMany(User::class, 'panel_id');
}

public function product()
{
    return $this->hasMany(Product::class, 'panel_id');
}

public function category()
{
    return $this->hasMany(Category::class,'panel_id');
}


}
