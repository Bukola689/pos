<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|unique:products,name|min:3|max:15',
            'description' => 'required|string|min:3|max:15',
            'category_id' => 'required|int',
            'price' => 'required|int',
            'discount' => 'required|int',
            'quantity' => 'required|int',
            'alert_stock' => 'required',
        ];
    }
}
