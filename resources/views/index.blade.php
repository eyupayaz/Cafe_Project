@extends('layouts.app')

@section('title', 'Ana Sayfa')

@section('content')
<!--Bu blade içerisine Home'u istediğin gibi yerleştir ve web.php ile yönet, admin tarafına api ile çıkış yapacaksın zaten vue farklı portta--->
<div class="text-center">
    <h1 class="text-4xl font-bold">Hoş Geldiniz</h1>
    <p class="text-gray-600 mt-4">Kafe Menü Sistemi ile menülerinizi kolayca yönetin ve müşterilerinizle paylaşın.</p>
    <a href="/menu" class="mt-6 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Menüye Göz Atın
    </a>
</div>
@endsection