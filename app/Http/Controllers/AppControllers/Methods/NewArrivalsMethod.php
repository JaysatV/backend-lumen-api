<?php


namespace App\Http\Controllers\AppControllers\Methods;

use App\Models\AppModels\NewArrivalsModel;
use App\Models\AppModels\CategoriesModel;
use Illuminate\Http\Request;
use DB;
class NewArrivalsMethod
{


    public function methodGetAllNew() {
    $new_arr = DB::table('products')
                ->join('new_arrivals', 'new_arrivals.p_code', '=', 'products.product_code')
                ->select('products.*')
                ->get();
    $index = 0;
    foreach ($new_arr as $nr) {
        $nr->product_cat_name = CategoriesModel::where('id',$nr->product_cat)->first()->cat_name;
    }
    return $new_arr;
		//return NewArrivalsModel::all();
		
    }
	
	public function methodCreateNew(Request $request) {
		$nals = NewArrivalsModel::create($request->all());
		return DB::table('products')->where('product_code',$request->p_code)->first();
	}
	
	public function methodDeleteNew(Request $request) {
		return NewArrivalsModel::where('p_code', $request->p_code)->delete();
	}
	
}