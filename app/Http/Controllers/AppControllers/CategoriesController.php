<?php


namespace App\Http\Controllers\AppControllers;
use App\Http\Controllers\AppControllers\Methods\CategoriesMethods;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;
use PHPUnit\Util\Json;

class CategoriesController extends BaseController
{


    public function getAllCategories(): JsonResponse {
        $cat_method = new CategoriesMethods();
        return response()->json($cat_method->methodGetAllCategories());
    }

	public function createNewCategory(Request $request): JsonResponse {
        $cat_method = new CategoriesMethods();
		$cat_method->methodCreateNewCategory($request);
        return response()->json($cat_method->methodGetAllCategories());
    }
    
    public function updateCategoryImage(Request $request): JsonResponse {
        $cat_method = new CategoriesMethods();
        return response()->json($cat_method->fileUpload($request, $request->id));
    }
    
    public function updateCategory(Request $request): JsonResponse {
        $cat_method = new CategoriesMethods();
        return response()->json($cat_method->methodUpdateCat($request));
    }

}
