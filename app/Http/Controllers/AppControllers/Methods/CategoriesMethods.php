<?php


namespace App\Http\Controllers\AppControllers\Methods;

use App\Models\AppModels\CategoriesModel;
use Illuminate\Http\Request;

class CategoriesMethods
{


    public function methodGetAllCategories() {
        return CategoriesModel::orderBy('visibility', 'DESC')->get();
    }
	
	public function methodCreateNewCategory(Request $request) {
		$cat = CategoriesModel::create($request->all());
		
		return $this->fileUpload($request, $cat->id);
        
	}
	
	public function methodUpdateCat(Request $request){
	    return CategoriesModel::where('id',$request->id)->update(json_decode(json_encode($request->data), true));
	}
	
	public function fileUpload(Request $request, $p_id) {
		
		if ($request->hasFile('product_image')) {
			$image = $request->file('product_image');
			$name = 'p_'.$p_id.'.jpg';
			//$name = 'img'.$id.'p1.'.$image->getClientOriginalExtension();
			$destinationPath = rtrim(app()->basePath('public/images/cat'), '/');
			$image->move($destinationPath, $name);
			return 'yes image';
		} else {
		    return 'no image';
		}
	}

}
