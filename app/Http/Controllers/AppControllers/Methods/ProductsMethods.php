<?php


namespace App\Http\Controllers\AppControllers\Methods;

use App\Models\AppModels\ProductsModel;
use App\Models\AppModels\UnitsModel;
use App\Models\AppModels\CategoriesModel;
use App\Http\Controllers\AppControllers\Methods\SettingsMethods;
use Illuminate\Http\Request;
use DB;
class ProductsMethods
{


    public function methodGetAllProducts() {
        $productsData = ProductsModel::all();
		$result_array = array();
		foreach($productsData as $product) {
			$cat_id = $product['product_cat'];
			$product['product_cat'] = CategoriesModel::find($cat_id)->cat_name;
			$product['cat_id'] = $cat_id;
			$unit_id = $product['product_unit'];
			$product['product_unit'] = UnitsModel::find($unit_id)->unit_name;
			$product['unit_id'] = $unit_id;
			array_push($result_array, $product); 
		}
		return $result_array;
    }
	
	public function methodCreateNewProduct(Request $request) {
		$product = ProductsModel::create($request->all());
		$this->fileUpload($request, $product->id);
		return $product;
		//return $request->product_code;
	}
	
	public function methodGetGroupProducts() {
		$cat_data = DB::table('products')
                 ->select('product_cat')
                 ->groupBy('product_cat')
                 ->get();
		
		$result_array = array();
		foreach($cat_data as $cat) {
			$data['cat_id'] = $cat->product_cat;
			//$data['cat_name'] = CategoriesModel::find($cat->product_cat)->cat_name;
			$cat_model = CategoriesModel::find($cat->product_cat);
			$data['cat_name'] = $cat_model->cat_name;
			$data['visibility'] = $cat_model->visibility;
			$data['product_data'] = array();
			$productsData = ProductsModel::where('product_cat', $cat->product_cat)->get();
			foreach($productsData as $product) {
				$product['unit_name'] = UnitsModel::find($product->product_unit)->unit_name;
				array_push($data['product_data'], $product);
			}
			array_push($result_array, $data);
		}
		return $result_array;
	}
	
	public function methodUpdateProduct(Request $request){
	    return ProductsModel::where('id',$request->id)->update(json_decode(json_encode($request->data), true));
	}
	
	public function methodUpdateDiscount(Request $request){
	   
	    $product = ProductsModel::query()->update(['product_discount' => $request->discount]);
	    $settings = new SettingsMethods();
	    $last_setting = $settings->methodGetLastSetting();
	    $request['paf'] =  $last_setting->paf;
	    
	   $settings->methodCreateNewSetting($request);
	    return  $product;
	}
	
	public function methodUpdateRateByDiscount(Request $request){
	    $result = array();
	   	foreach(ProductsModel::get(['id','product_rate','product_discount']) as $pr) {
			$discount =$pr->product_rate - (($pr->product_rate * $pr->product_discount)/100);
			$rate_discount = ($discount / (100 - $request->discount)) * 100;
			$discount_data = array("id" => $pr->id,"product_discount" =>$request->discount, "product_rate" => $rate_discount);
			ProductsModel::where('id',$pr->id)->update(json_decode(json_encode($discount_data), true));
			array_push($result, $discount_data);
		}
		$settings = new SettingsMethods();
	    $last_setting = $settings->methodGetLastSetting();
	    $request['paf'] =  $last_setting->paf;
	    
	   $settings->methodCreateNewSetting($request);
	    return  $result;
	}
	
	public function methodDeleteProduct(Request $request) {
	    return ProductsModel::where('id', $request->id)->delete();
	} 
	
	
	
	public function fileUpload(Request $request, $p_id) {
		
		if ($request->hasFile('product_image')) {
			$image = $request->file('product_image');
			$name = 'p_'.$p_id.'.jpg';
			//$name = 'img'.$id.'p1.'.$image->getClientOriginalExtension();
			$destinationPath = rtrim(app()->basePath('public/images/products'), '/');
			$image->move($destinationPath, $name);
		} 
	}
	
}
