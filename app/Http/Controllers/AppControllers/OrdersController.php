<?php


namespace App\Http\Controllers\AppControllers;
use App\Http\Controllers\AppControllers\Methods\OrderMethods;
use App\Http\Controllers\AppControllers\Methods\ProductsMethods;
use App\Http\Controllers\AppControllers\Methods\CustomersMethods;
use App\Http\Controllers\AppControllers\Methods\UnitMethods;
use App\Http\Controllers\AppControllers\Methods\CategoriesMethods;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;
use PHPUnit\Util\Json;

class OrdersController extends BaseController
{


    public function getAllOrders(Request $request): JsonResponse {
        $orders_method = new OrderMethods();
        return response()->json($orders_method->methodGetAllOrders($request));
    }
	
	


    public function getCustomersOrders($phone_number): JsonResponse {
        $orders_method = new OrderMethods();
        return response()->json($orders_method->methodGetCustomerOrders($phone_number));
    }

	 public function createNewOrder(Request $request): JsonResponse {
        $orders_method = new OrderMethods();
        return response()->json($orders_method->methodCreateOrder($request));
    }
	
	 public function getOrderItems($order_id): JsonResponse {
        $orders_method = new OrderMethods();
        return response()->json($orders_method->methodGetOrderItems($order_id));
    }
    
     public function updateOrder(Request $request): JsonResponse {
        $orders_method = new OrderMethods();
        return response()->json($orders_method->updateOrder($request));
    }
	
	 public function updateOrderItems(Request $request): JsonResponse {
        $orders_method = new OrderMethods();
        return response()->json($orders_method->updateOrderItems($request));
    }
    
    
	 public function updateOrderItemsDiscount(Request $request): JsonResponse {
        $orders_method = new OrderMethods();
        return response()->json($orders_method->updateOrderItemsDiscount($request));
    }
    
    public function deleteOrderItem(Request $request): JsonResponse {
        $orders_method = new OrderMethods();
        return response()->json($orders_method->methodDeleteOrderItem($request));
    }
    
     public function insertOrderItem(Request $request): JsonResponse {
        $orders_method = new OrderMethods();
        return response()->json($orders_method->insertOrderItem($request));
    }



}
