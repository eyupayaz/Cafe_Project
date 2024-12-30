<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query'); // Kullanıcının arama sorgusunu al

        // Sonuçları HTML olarak birleştirmek için başlangıç
        $productsHtml = '';

        if ($query) {
            // Kategori adında arama yap
            $products = Product::where('name', 'like', '%' . $query . '%')->get();

            if ($products->count() > 0) {
                $productsHtml = '<ul class="dropdown-menu show" style="position: absolute; top: 100%; left: 0; width: 100%; z-index: 1000;">';

                foreach ($products as $row) {
                    $productsHtml .= '
                    <li class="dropdown-item">
                        <a href="urunler/' . htmlspecialchars($row->id) . '" style="text-decoration: none;">' . htmlspecialchars($row->name) . '</a>
                    </li>';
                }

                $productsHtml .= '</ul>';
            } else {
                $productsHtml = '<ul class="dropdown-menu show" style="position: absolute; top: 100%; left: 0; width: 100%; z-index: 1000;">
                    <li class="dropdown-item">Sonuç Yok</li>
                </ul>';
            }
        } else {
            $productsHtml = '<ul class="dropdown-menu show" style="position: absolute; top: 100%; left: 0; width: 100%; z-index: 1000;">
                <li class="dropdown-item">Lütfen bir arama terimi giriniz.</li>
            </ul>';
        }

        return response()->json([
            'html' => $productsHtml
        ]);
    }
}
