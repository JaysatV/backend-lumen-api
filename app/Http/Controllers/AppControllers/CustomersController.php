<?php


namespace App\Http\Controllers\AppControllers;
use App\Http\Controllers\AppControllers\Methods\ProductsMethods;
use App\Http\Controllers\AppControllers\Methods\CustomersMethods;
use App\Http\Controllers\AppControllers\Methods\UnitMethods;
use App\Http\Controllers\AppControllers\Methods\CategoriesMethods;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;
use PHPUnit\Util\Json;

class CustomersController extends BaseController
{


    public function getAllCustomers(): JsonResponse {
        $customer_method = new CustomersMethods();
        return response()->json($customer_method->methodGetAllCustomers());
    }

	public function createNewCustomer(Request $request): JsonResponse {
        $customer_method = new CustomersMethods();
		
        return response()->json($customer_method->methodCreateNewCustomer($request));
    }
	


}
