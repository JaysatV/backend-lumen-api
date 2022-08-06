<?php


namespace App\Http\Controllers\AppControllers;
use App\Http\Controllers\AppControllers\Methods\NewArrivalsMethod;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;
use PHPUnit\Util\Json;

class NewArrivalsController extends BaseController
{


    public function getAllNew(): JsonResponse {
        $new_arrivals_method = new NewArrivalsMethod();
        return response()->json($new_arrivals_method->methodGetAllNew());
    }

	public function createNew(Request $request): JsonResponse {
        $new_arrivals_method = new NewArrivalsMethod();
		
        return response()->json($new_arrivals_method->methodCreateNew($request));
    }
    
    public function deleteNew(Request $request): JsonResponse {
        $new_arrivals_method = new NewArrivalsMethod();
		
        return response()->json($new_arrivals_method->methodDeleteNew($request));
    }
	


}