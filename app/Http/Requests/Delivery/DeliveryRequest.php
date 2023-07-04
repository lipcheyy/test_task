<?php

namespace App\Http\Requests\Delivery;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryRequest extends FormRequest
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
            'width'=>'required|string',
            'height'=>'required|string',
            'length'=>'required|string',
            'weight'=>'required|string',
            'courier'=>'required',
            'customer_name'=>'required|string',
            'phone_number'=>'required|string',
            'email'=>'required|string',
            'sender_address'=>'required|string',
            'delivery_address'=>'required|string',
        ];
    }
}
