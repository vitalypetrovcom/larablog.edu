<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategory extends FormRequest { // С помощью данного класса мы описываем валидацию для наших категорий и все, что остается сделать - в CategoryController.php в public function store(Request $request) вместо Request созданный нами класс StoreCategory, те public function store(StoreCategory $request)
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() { // Метод, который определяет кто будет иметь доступ к данному request (https://laravel.com/docs/8.x/validation#authorizing-form-requests)
        return true; // Доступ имеют все администраторы
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() { // Метод, который определяет валидационные правила(https://laravel.com/docs/8.x/validation#creating-form-requests)
        return [
            'title' => 'required',
        ];
    }
}
