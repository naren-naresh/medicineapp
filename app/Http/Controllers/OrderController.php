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
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    public function adminIndex(Request $request){

        if ($request->ajax()) {

            $orders = $this->getOrderQuery($request->typeValue) ?? [];
            if (Carbon::now()->isSameDay($request->start) == false || Carbon::now()->isSameDay($request->end) == false) {
                if($request->has('start') && $request->has('end'))
                {
                    $orders = $orders->whereBetween('created_at', [$request->start, $request->end]);
                }
             }
            return DataTables::of($orders)
                ->addColumn('checkbox', function ($order) {
                    $check = '<input type="checkbox" name="check" class="check" orderId ='.$order->id.' statusId ='.$order->order_status.'>';
                    return $check ;
                })
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
                    $orderStatus = orderStatus::where('id',$order->order_status);
                    $statusHtml = '<p class="text-center badge px-2 py-2" style = "color:'.$orderStatus->value('color_code').';background-color:'.$orderStatus->value('bg_color_code').';font-size:12px";>'.$orderStatus->value('status').'</p>';
                    return $statusHtml;
                })
                ->addColumn('action', function ($order) {
                        $btn = '<div class ="row action">';

                        $btn .= '<a href="'.route('ordersDetails.admin',$order->customer_id).'" class="view text-decoration-none pb-1" style ="color:#385399"><i class="fa fa-eye mx-1"></i> View Order</a>';

                        if ($order->order_status == 2) {
                            $btn .= '<a href="#" class="confirm text-decoration-none pb-1" style ="color:#385399" order_id = '.$order->id.' order_status = '.$order->order_status.'><i class="far fa-check-square mx-1"></i> Mark us Confirm</a>';
                        }

                        if ($order->order_status == 3) {
                            $btn .= '<a href="#" class="shipped text-decoration-none pb-1" style ="color:#385399" order_id = '.$order->id.' order_status = '.$order->order_status.'><i class="fa fa-truck mx-1"></i>Move to Shipped</a>';
                        }

                        if ($order->order_status == 4) {
                            $btn .= '<a href="#" class="delivered text-decoration-none pb-1" style ="color:#385399;" order_id = '.$order->id.' order_status = '.$order->order_status.'><i class="fa fa-shipping-fast mx-1"></i>Out for Delivered</a>';
                        }

                        $btn .= '<a href="#" class="delete text-decoration-none" style ="color:#385399"><i class="fa fa-close  mx-1"></i> Cancel Order</a>';

                        $btn .= '</div>';
                        return $btn;
                })
                ->rawColumns(['checkbox','id','order_date','price','address','status', 'action'])
                ->make(true);
        }
        $data['orderStatus'] =  orderStatus::all();
       return view('admin.orders.index',$data);
    }

    public function getOrderQuery($type){
         $orderData = Order::all();
         if ( empty($type) || $type == 'placed') {
            $orderData = $orderData->whereIn('order_status',[1,2,3]);
         }elseif ($type == 'shipped') {
            $orderData = $orderData->whereIn('order_status',[4,5]);
         }elseif ($type == 'completed') {
            $orderData = $orderData->where('order_status', 6);
         }elseif ($type == 'canceled') {
            $orderData = $orderData->where('order_status',7);
         }
         return $orderData;
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

    public function statusUpdate(Request $request)
    {
        if ($request->ajax()) {
            $updateData = ['order_status' => 2];

            $order = Order::where('id',$request->order_id)->first();

            if ($order) {
                $updateData['status_change'] = 1;
                $updateResult = $order->updateStatus($updateData);

                if ($updateResult) {
                    return response()->json(['message' => 'Order status updated successfully', 'data' => $updateResult], 200);
                } else {
                    return response()->json(['message' => 'Error updating order status'], 500);
                }
            } else {
                return response()->json(['message' => 'Order not found'], 404);
            }
        }

        return response()->json(['message' => 'Invalid request'], 400);
    }

    public function shipment(Request $request){
          if ($request->ajax()) {
            $updateData = ['order_status' => $request->update_value];

            $orders = Order::whereIn('id',$request->order_id)->get();

            if ($orders) {
                foreach ($orders as $orderValue) {
                        $updateResult = $orderValue->updateStatus($updateData);
                }

                if ($updateResult) {
                    return response()->json(['message' => 'Order status updated successfully', 'data' => $updateResult], 200);
                } else {
                    return response()->json(['message' => 'Error updating order status'], 500);
                }
            } else {
                return response()->json(['message' => 'Order not found'], 404);
            }
          }
          return response()->json(['message' => 'Invalid request'], 400);
    }

    public function confirmOrder(Request $request){
        if ($request->ajax()) {
           if ($request->order_status == 2) {
              $updateStatusData = ['order_status' => 3];
              $order =  Order::where('id',$request->order_id)->first();
              $updateResult =$order->updateStatus($updateStatusData);
              if ($updateResult) {
                return response()->json(['success' => 'Order status updated successfully', 'data' => $updateResult], 200);
            } else {
                return response()->json(['message' => 'Error updating order status'], 500);
            }
           }
        }
        return response()->json(['message' => 'Invalid request'], 400);
    }

    public function invoiceDownload($id) {
        $data['orderDetails'] = Order::where('customer_id',$id)->get();
        $data['addresses'] = Address::all();
        $data['orderItems'] = OrderItem::all();
        $data['orderStatus'] = orderStatus::all();
        $data['payments'] = OrderPayment::all();
        $data['deliveryZone'] = Delivery_zone::all();
        $data['deliveryFee'] = DeliveryFee::all();

        $pdf = Pdf::loadView('admin.orders.order_invoice',['data' => $data]);

        return $pdf->download('invoice.pdf');
        // return view('admin.orders.order_invoice',['data' => $data]);
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
