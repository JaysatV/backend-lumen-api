<?php


namespace App\Http\Controllers\AppControllers\Methods;

use App\Models\AppModels\ProductsModel;
use App\Models\AppModels\CustomersModel;
use App\Models\AppModels\UnitsModel;
use App\Models\AppModels\CategoriesModel;
use Illuminate\Http\Request;

class CustomersMethods
{


    public function methodGetAllCustomers() {

		return CustomersModel::all();
    }
	
	public function methodCreateNewCustomer(Request $request) {
		return CustomersModel::create($request->all());
	}
	
}
