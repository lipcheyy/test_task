<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Delivery\DeliveryRequest;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function store(DeliveryRequest $request){
        $size=[
            'width'=>$request->validated()['width'],
            'height'=>$request->validated()['height'],
            'length'=>$request->validated()['length'],
            'weight'=>$request->validated()['weight']
        ];
        $customer=[
            'customer_name'=>$request->validated()['customer_name'],
            'phone_number'=>$request->validated()['phone_number'],
            'email'=>$request->validated()['email'],
            'sender_address'=>$request->validated()['sender_address'],
            'delivery_address'=>$request->validated()['delivery_address']
        ];
    }
    private function courierUrl(string $courier){
        $urls=[
            'NovaPoshta'=>'http://novaposhta.test/api/delivery',
            'UkrPoshta' => 'http://ukrposhta.test/api/delivery',
        ];
        return $urls['courier'] ??null;
    }
}
