<?php


namespace App\Http\Controllers\AppControllers\Methods;

use App\Models\AppModels\UnitsModel;
use Illuminate\Http\Request;

class UnitMethods
{


    public function methodGetUnits() {
        return UnitsModel::all();
    }
	
	public function methodCreateNewUnit(Request $request) {
		return UnitsModel::create($request->all());
	}

}
