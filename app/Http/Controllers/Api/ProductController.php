<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Panel;
use App\Models\User;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;  

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(5);
        return response()->json($products);
    }

    public function store(StoreProductRequest $request, Panel $panel)
{
    $panelId = $panel->id;

    $data=$request->validated();

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('products', 'public');
    }

    $data['panel_id'] = $panelId;

    $product = Product::create($data); // doğru kullanım 

    // Başarılı yanıt döndür
    return response()->json([
        'status' => 201,
        'message' => 'Ürün başarıyla oluşturuldu!',
        'data' => $product,
    ], 201);
}


  
    public function show(Product $product)
    {
       return response()->json($product); // İmplicit(otomatik) model binding işlemi
    }

    
    public function edit(Product $product)
    {
            $categories = Category::all();
    
            // Ürünü ve kategorileri döndür
            return response()->json([
                'product' => $product,
                'categories' => $categories,
            ]);
            
            return response()->json([
                'message' => 'Ürün bilgileri alınırken hata oluştu.',
                'error' => $e->getMessage(),
            ], 500);
        }
    
   
    public function update(UpdateProductRequest $request, Product $product)
{
        if ($request->hasFile('image')) {
            // Eski resmi sil
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // Yeni resmi kaydet
            $imagePath = $request->file('image')->store('products', 'public');
            $request->merge(['image' => $imagePath]); // Resim yolunu request'e ekle
        }

        $product->update($request->only(['name', 'slug', 'description', 'price', 'category_id', 'image', 'panel_id']));

        return response()->json(['message' => 'Ürün başarıyla güncellendi.', 'product' => $product], 200);
}           

    public function destroy(Product $product):JsonResponse
    {
            $product->delete();
            return response()->json(['message' => 'Ürün başarıyla silindi.'], 200);
    }
}
