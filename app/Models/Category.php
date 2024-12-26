<?php
namespace App\Models;
use App\Models\Product;
use App\Models\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug', 
        'image',
        'panel_id',
    ];

    // Kategorinin ürünleriyle ilişkisi
    public function products()
    {
        return $this->hasMany(Product::class);
    }   

    public function Panel()
    {
        return $this->belongsTo(Panel::class, 'panel_id', 'id');
    }

    


    


}