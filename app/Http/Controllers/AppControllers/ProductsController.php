<?php


namespace App\Http\Controllers\AppControllers;
use App\Http\Controllers\AppControllers\Methods\ProductsMethods;
use App\Http\Controllers\AppControllers\Methods\UnitMethods;
use App\Http\Controllers\AppControllers\Methods\CategoriesMethods;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;
use PHPUnit\Util\Json;

class ProductsController extends BaseController
{


    public function getAllProducts(): JsonResponse {
        $product_method = new ProductsMethods();
        return response()->json($product_method->methodGetAllProducts());
    }

	public function createNewProduct(Request $request): JsonResponse {
        $product_method = new ProductsMethods();
		
        return response()->json($product_method->methodCreateNewProduct($request));
    }
    
    public function deleteProduct(Request $request): JsonResponse {
        $product_method = new ProductsMethods();
        return response()->json($product_method->methodDeleteProduct($request));
    }
    
    public function updateProduct(Request $request): JsonResponse {
        $product_method = new ProductsMethods();
        return response()->json($product_method->methodUpdateProduct($request));
    }
    
    public function updateProductImage(Request $request, $p_id): JsonResponse {
        $product_method = new ProductsMethods();
        return response()->json($product_method->fileUpload($request, $p_id));
    }
	
	public function updateProductDiscount(Request $request): JsonResponse {
        $product_method = new ProductsMethods();
        return response()->json($product_method->methodUpdateDiscount($request));
    }
    
	public function updateProductRateByDiscount(Request $request): JsonResponse {
        $product_method = new ProductsMethods();
        return response()->json($product_method->methodUpdateRateByDiscount($request));
    }
    
	public function getCatAndUnit(): JsonResponse {
        $result_array = array();
		$unit_method = new UnitMethods();
		$cat_method = new CategoriesMethods();
		$result_array['unit_data'] = $unit_method->methodGetUnits();
		$result_array['cat_data'] = $cat_method->methodGetAllCategories();
        return response()->json($result_array);
    }
	
	public function getGroupProducts(): JsonResponse {
		$product_method = new ProductsMethods();
        return response()->json($product_method->methodGetGroupProducts());
	}

}
