<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Panel;
use App\Models\User;
use App\Http\Requests\Category\StoreCategoryRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class CategoryController extends Controller
{
    public function index()
    {
        //$categories = Category::Paginate(5);
        $categories = Category::all();
        return response()->json($categories);
    }

    public function store(StoreCategoryRequest $request)
{
    $user = Auth::user();

    $panelId = $user->panel_id; // Panel ID'yi al

    // Validasyon verilerini al
    $data = $request->validated();

    // Resim varsa kaydet ve $data'ya ekle
    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('categories', 'public');
    }

    $data['panel_id'] = $panelId;

    $category = Category::create($data);

    return response()->json([
        'status' => 200,
        'message' => 'Kategori başarıyla oluşturuldu!',
        'data' => $category,
    ], 200);
}

   
    public function destroy(Category $category)
    {
            $category->delete();
            return response()->json(['message' => 'Kategori silindi.'], 200);
        }
    }

