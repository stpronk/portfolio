<?php

namespace App\Http\Requests\Finance;

use App\Models\Finance\Category;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryCreateRequest extends FormRequest
{
//    public $category;

    public function rules()
    {
        return [
            'name'             => 'required|string|max:255',
            'color'            => 'required|string|max:7',
            'finance_group_id' => 'required|int|exists:App\Models\Finance\Group,id',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function save()
    {
        $this->category = new Category();

        $this->category->name             = $this->name;
        $this->category->color            = $this->color;
        $this->category->finance_group_id = $this->finance_group_id;

        $this->category->save();

        return $this->category;
    }

    public function jsonResponse()
    {
        return $this->category->toArray();
    }

    /**
     * If validator fails return the exception in json form
     *
     * @param Validator $validator
     *
     * @return void
     * @throws \HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'errors' => $validator->errors()
            ], 422));
    }
}
