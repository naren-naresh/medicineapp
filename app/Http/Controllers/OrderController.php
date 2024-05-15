<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Delivery_zone;
use App\Models\DeliveryFee;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPayment;
use App\Models\orderStatus;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    public function adminIndex(Request $request){
        if ($request->ajax()) {
            $orders = Order::latest()->get() ?? [];
            if($request->filled('from_date') && $request->filled('to_date'))
            {
                $orders = $orders->whereBetween('created_at', [$request->from_date, $request->to_date]);
            }
            return DataTables::of($orders)
                ->addIndexColumn()
                ->addColumn('order_id', function ($order) {
                    return $order->order_number;
                })
                ->addColumn('order_date', function ($order) {
                    $date = date('d M, Y h:i A',strtotime($order->created_at));
                    return $date;
                })
                ->addColumn('items', function ($order) {
                    $itemCount = OrderItem::where('order_id',$order->id)->get('id');
                    return count($itemCount);
                })
                ->addColumn('price', function ($order) {
                    $price = '<p>₹'. $order->final_payable_amount.'</p>';
                    return $price;
                })
                ->addColumn('address', function ($order) {
                    $postal_code = Address::where('id',$order->address_id)->value('postal_code');
                    $address ='<p class="mb-2"><i class="fa fa-user-circle"></i> '.$order->customer_name.'</p>
                               <p class="mb-2"><i class="fa fa-map-location"></i> '.$order->address.'</p>
                               <p class="mb-2"><i class="fa fa-map-pin"></i> '.$postal_code.'</p>
                               <p><i class="fa fa-phone"></i> '.$order->customer_contact_number.'</p>';
                    return $address;
                })
                ->addColumn('status', function ($order) {
                    return orderStatus::where('id',$order->order_status)->value('status');
                })
                ->addColumn('action', function ($order) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $order->id . '" data-original-title="Edit" class="edit btn  btn-sm editProduct">View</a>
                        <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $order->id . '" data-original-title="Delete" class="btn btn-sm deleteProduct">Cancel</a>';
                    return $btn;
                })
                ->rawColumns(['id','order_date','price','address','status', 'action'])
                ->make(true);
        }
       return view('admin.orders.index');
    }

    public function adminOrderDetails($id){
        $data['orderDetails'] = Order::where('customer_id',$id)->get();
        $data['addresses'] = Address::all();
        $data['orderItems'] = OrderItem::all();
        $data['orderStatus'] = orderStatus::all();
        $data['payments'] = OrderPayment::all();
        $data['deliveryZone'] = Delivery_zone::all();
        $data['deliveryFee'] = DeliveryFee::all();

        return view('admin.orders.order_info',$data);
    }

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
                if ($order) {
                    Cart::where('id',$cartDetail['cart_id'])->delete();
                }
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
        $data['deliveryZone'] = Delivery_zone::all();
        $data['deliveryFee'] = DeliveryFee::all();
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
