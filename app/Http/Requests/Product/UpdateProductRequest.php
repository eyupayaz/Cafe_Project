<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|integer|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'panel_id' => 'nullable|numeric',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Ürün adı zorunludur.',
            'slug.required' => 'Slug alanı zorunludur.',
            'price.required' => 'Fiyat alanı zorunludur.',
            'category_id.exists' => 'Seçilen kategori geçerli değil.',
            'image.image' => 'Yüklenen dosya bir resim olmalıdır.',
        ];
    }
}
