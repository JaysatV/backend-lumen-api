<?php


namespace App\Http\Controllers\AppControllers;
use App\Http\Controllers\AppControllers\Methods\UnitMethods;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;
use PHPUnit\Util\Json;

class UnitsController extends BaseController
{


    public function getAllUnits(): JsonResponse {
        $unit_method = new UnitMethods();
        return response()->json($unit_method->methodGetUnits());
    }

	public function createNewUnit(Request $request): JsonResponse {
        $unit_method = new UnitMethods();
		$unit_method->methodCreateNewUnit($request);
        return response()->json($unit_method->methodGetUnits());
    }

}
