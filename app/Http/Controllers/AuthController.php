<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Panel; 
use App\Http\Requests\Auth\RegisterAuthRequest;
use App\Http\Requests\Auth\LoginAuthRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    public function register(RegisterAuthRequest $request)
    {
        $data = $request->validated();
        $panelData = $request->validated();

        $user = User::create($data);

        $token = $user->createToken('auth_token')->plainTextToken;
    
        // Kullanıcı oluşturulduktan sonra bir panel oluştur
        $panelData = [
            'user_id' => $user->id, // Kullanıcı ile ilişkiyi sağla
            'title' => $user->name,
            'content' => 'panel içeriğiniz burada yer alacak',
        ];

        $panel = Panel::create($panelData);

        return response()->json([
            'message' => 'Kullanıcı başarıyla kaydedildi ve panel oluşturuldu.',
            'user' => $user,
            'token' => $token,
            'panel' => $panel,  
        ], 201);
    }


public function login(LoginAuthRequest $request)
{
    $credentials = $request->validated(); //Doğrulanmış verileri al

    // Kullanıcıyı doğrula
    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        $user->tokens()->delete();

        $token = $user->createToken('authToken')->plainTextToken;

        // Kullanıcı rolüne göre yanıt döndür
        $roleMessage = $user->role === 'admin' 
            ? 'Admin olarak giriş yaptınız.' 
            : 'Kullanıcı olarak giriş yaptınız.';

        return response()->json([
            'message' => $roleMessage,
            'role' => $user->role,
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    // Giriş başarısız ise hata döndür
    return response()->json([
        'message' => 'Geçersiz giriş bilgileri.',
    ], 401);
}


public function logout(Request $request)
    {
        Auth::user()->tokens()->delete(); //kullanıcının tüm tokenleri siler.

        return response()->json(['message' => 'Çıkış başarılı'], 200);
    }
    

public function user(Request $request)
{
    return response()->json($request->user());
}
}
