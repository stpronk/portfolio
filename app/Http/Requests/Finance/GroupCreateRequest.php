<?php

namespace App\Http\Requests\Finance;

use App\Models\Finance\Group;
use Illuminate\Foundation\Http\FormRequest;

class GroupCreateRequest extends FormRequest
{
    public $group;

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
            'owner_id' => 'integer|exists:App\Models\User,id',
            'name'     => 'string|min:3|max:255'
        ];
    }

    public function save()
    {
        $this->group = new Group();

        $this->group->owner_id = $this->owner_id;
        $this->group->name = $this->name;

        $this->group->save();

        return $this->group;
    }
}
