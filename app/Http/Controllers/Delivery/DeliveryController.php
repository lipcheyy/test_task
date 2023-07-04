<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Delivery\DeliveryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DeliveryController extends Controller
{
    public function store(DeliveryRequest $request){
        //Отримуємо дані про розмір посилки та дані клієнта
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
        //Визначаємо url вибраної кур'єрської служби та перевіряємо, чи така служба існує
        $courierUrl=$this->courierUrl($request->validated()['courier']);
        if ( $courierUrl===null){
            return response()->json(['error' => 'courier service not found']);
        }
        //відправка контракту на сервер кур'єрської служби
        $sendToDeliveryService=Http::post($courierUrl,[
            'customer_name'=>$customer['customer_name'],
            'phone_number'=>$customer['phone_number'],
            'email'=>$customer['email'],
            'sender_address'=>$customer['sender_address'],
            'delivery_address'=>$customer['delivery_address']
        ]);
        //обробник відповіді сервера кур'єрської служби
        if ($sendToDeliveryService->successful()){
            return response()->json(['message'=>'data successfully send']);
        }
        else{
            return response()->json(['error' => 'error while sending data']);
        }
    }
    private function courierUrl(string $courier){
        //url адреси нових кур'єрських служб можна додати в цей масив
        $urls=[
            'NovaPoshta'=>'http://novaposhta.test/api/delivery',
            'UkrPoshta' => 'http://ukrposhta.test/api/delivery',
        ];
        return $urls['courier'] ??null;
    }
}
