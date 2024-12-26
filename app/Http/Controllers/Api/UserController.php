<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\LoginUserRequest;
use App\Models\User;
use App\Models\Panel;



class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }


    public function login(LoginUserRequest $request)
{

    if (Auth::attempt($request->only('email', 'password'))) {
        $user = Auth::user();

        // Eski token'ları temizle
        $user->tokens()->delete();

        // Yeni bir token oluştur
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'Giriş başarılı',
            'token' => $token,
            'user' => $user,
        ]);
    }

    return response()->json(['message' => 'Giriş bilgileri yanlış'], 401);
}

    public function store(StoreUserRequest $request)
    {
    
        $data=$request->validated();
        $user = User::create($data);
    
        return response()->json([
            'status' => true,
             'message' => 'Yeni kullanıcı oluşturuldu',
             'token' => $users->createToken("API TOKEN")->plainTextToken
        ], 200);
    }

    
    public function show(Users $users)
    {
        return response()->json($users); //Ipmlicit model binding işlemi 

    }
}
