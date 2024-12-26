@extends('layouts.app')

@section('title', 'Menü')

@section('content')
<div>
    <h2 class="text-2xl font-bold mb-4">Menü</h2>
    <ul>
        @foreach($categories as $category)
            <li class="mb-4">
                <h3 class="text-xl font-semibold">{{ $category->name }}</h3>
                <ul class="ml-4">
                    @foreach($category->products as $product)
                        <li class="flex justify-between items-center py-2">
                            <span>{{ $product->name }}</span>
                            <span class="text-gray-500">{{ $product->price }} ₺</span>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</div>

@endsection
