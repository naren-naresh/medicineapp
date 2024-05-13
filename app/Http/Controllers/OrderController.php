<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPayment;
use App\Models\orderStatus;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $data['categories'] = Category::where('parent_category_id', null)->limit(6)->get();
        $data['orderDetails'] = Order::where('customer_id',auth()->id())->get();
        $data['orderStatus'] = orderStatus::all();
        return view('frontend.profile.orders',$data);
    }

    public function store(Request $request)
    {
        $orderNo = $this->generateOrderNumber();
        if ($request->ajax()) {

            $cartDetails = $request->cart_data;
            $customer_address = Address::where('id', $request->address_id)->get();
            foreach ($customer_address as $addressData) {
            $orderData = ['order_number' => $orderNo , 'customer_id' => auth()->id() , 'customer_name' => $addressData->name , 'customer_contact_number' => $addressData->contact_number,
            'address_id' => $addressData->id , 'address' => $addressData->address , 'address_notes' => $addressData->notes , 'total_amount' =>$request->total_mrp ,'discount_amount' => $request->total_discount,
            'final_payable_amount' => $request->total_paid , 'order_status' => 1 ,'order_created_date_time' => now() ];
            $order = new Order;
            $order = $order->create($orderData);
            }
            foreach ($cartDetails as $cartDetail) {
                $orderItems = ['order_id' => $order->id , 'product_id' => $cartDetail['product_id'] , 'product_name' => $cartDetail['product_name'] , 'product_image' => $cartDetail['product_image'],
                              'product_sku' => $cartDetail['Product_sku'] , 'product_variant_id' => $cartDetail['variant_id'] , 'product_variant_name' => $cartDetail['variant_name'] ,
                               'selling_price' => $cartDetail['product_selling_price'] , 'retail_price' => $cartDetail['product_retail_Price'] , 'quantity' => $cartDetail['product_quantity'] , 'total_amount' =>  $cartDetail['product_quantity'] * $cartDetail['product_selling_price']];

                $oderItemData = OrderItem::create($orderItems);
            }
            if ($order) {
                $oderPayment = ['order_id' => $order->id , 'payment_method' => $request->payment_method , 'date_time' => $order->order_created_date_time , 'payable_amount' => $request->total_paid , 'payment_status' => 'Paid'];
                $oderPaymentData = OrderPayment::create($oderPayment);
            }


        }
        return response()->json([
            'message' => 'Order created successfully!',
            'order' => $order,
            'orderItems' => $oderItemData,
            'orderPayment' => $oderPaymentData,
        ]);
    }

    public function orderDetails()
    {
        $data['categories'] = Category::where('parent_category_id', null)->limit(6)->get();
        $data['orderDetails'] = Order::where('customer_id',auth()->id())->get();
        $data['addresses'] = Address::all();
        $data['orderItems'] = OrderItem::all();
        $data['orderStatus'] = orderStatus::all();
        $data['payments'] = OrderPayment::all();
        return view('frontend.profile.orders-details',$data);
    }
    public function generateOrderNumber()
    {
        $year = date('y');
        $month = date('m');
        $data1 = $year . "" . $month . "" . auth()->id();
        $data2 = Order::count() + 1;

        $combinedLength = strlen($data1) + strlen($data2);
        $paddingLength = 12 - $combinedLength;

        $orderNumber = $data1;

        if ($combinedLength < 12) {
            $orderNumber .= str_pad('', $paddingLength, '0');
            $orderNumber .= $data2;
        } else {
            $orderNumber .= $data2;
        }

        return $orderNumber;
    }
}
