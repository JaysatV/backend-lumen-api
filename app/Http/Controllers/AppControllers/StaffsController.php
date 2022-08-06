<?php

namespace App\Http\Controllers\AppControllers;
use App\Http\Controllers\AppControllers\Methods\StaffsMethods;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;
use PHPUnit\Util\Json;

class StaffsController extends BaseController
{


    public function getAllStaffs(): JsonResponse {
        $staff_method = new StaffsMethods();
        return response()->json($staff_method->methodGetStaffs());
    }

	public function createNewStaff(Request $request): JsonResponse {
        $staff_method = new StaffsMethods();
        return response()->json($staff_method->methodCreateNewStaff($request));
    }
    
    public function updateStaff(Request $request): JsonResponse {
        $staff_method = new StaffsMethods();
        return response()->json($staff_method->methodUpdateStaff($request));
    }
    
    
     public function login(Request $request): JsonResponse {
        $staff_method = new StaffsMethods();
        return response()->json($staff_method->methodLogin($request));
    }
   

}
