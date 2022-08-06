<?php


namespace App\Http\Controllers\AppControllers;
use App\Http\Controllers\AppControllers\Methods\SettingsMethods;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;
use PHPUnit\Util\Json;

class SettingsController extends BaseController
{


    public function getAllSettings(): JsonResponse {
        $settings_method = new SettingsMethods();
        return response()->json($settings_method->methodGetAllSettings());
    }

	public function createNewSetting(Request $request): JsonResponse {
         $settings_method = new SettingsMethods();
        return response()->json($settings_method->methodCreateNewSetting($request));
    }

    public function getLastSettings(): JsonResponse {
        $settings_method = new SettingsMethods();
        return response()->json($settings_method->methodGetLastSetting());
    }
}