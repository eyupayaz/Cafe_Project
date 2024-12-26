<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Panel;

class PanelController extends Controller
{

    public function getPanel($id)
{
    $user = Auth::user();

    if ($user->id != $id) {
        return response()->json(['error' => 'Yetkisiz erişim.'], 403);
    }

    // Kullanıcının panel bilgilerini al
    $panel = Panel::where('user_id', $id)->first();

    if (!$panel) {
        return response()->json(['error' => 'Panel bulunamadı.'], 404);
    }

    // Panel bilgilerini döndür
    return response()->json([
        'message' => 'Panel bilgileri başarıyla alındı.',
        'title' => $panel->title,  // Gerekli verileri gönderebilirsiniz
        'content' => $panel->content, // Gereksiz verileri göndermemek için
    ]);
}

    // Kullanıcıya ait kategorileri getirme

    public function getCategories(Request $request)
{
    // Kullanıcı doğrulama
    if (!Auth::check()) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

        $user = Auth::user();
        $categories = Category::where('panel_id', $user->id)->get();
        return response()->json($categories);
}

// Kullanıcıya ait ürünleri getirme
    public function getProducts(Request $request)
{
    $PanelId = auth()->user()->Panel->id; // Kullanıcının user_panel_id'sini al
    $products = Product::where('panel_id', $PanelId)->get(); // user_panel_id'ye göre ürünleri çek
    return response()->json($products);
}

}
