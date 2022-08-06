<?php


namespace App\Http\Controllers\AppControllers\Methods;

use App\Models\AppModels\SettingsModel;
use Illuminate\Http\Request;

class SettingsMethods
{


    public function methodGetAllSettings() {
        return SettingsModel::all();
    }
	
	public function methodCreateNewSetting(Request $request) {
		return SettingsModel::create($request->all());
	}
	
	 public function methodGetLastSetting() {
        return SettingsModel::latest('id')->first();
    }

}