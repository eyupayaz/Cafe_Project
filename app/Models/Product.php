<?php 
namespace App\Models;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'category_id',
        'image',
        'panel_id',];
    
    // Ürünün ait olduğu kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function Panel()
    {
        return $this->belongsTo(Panel::class, 'panel_id', 'id');
    }
    

}
