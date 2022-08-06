<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


$router->group(['prefix' => 'api'], function($router){

    $router->group(['prefix' => 'categories'], function ($router){

         $router->get('/', 'AppControllers\CategoriesController@getAllCategories');
		 $router->post('/', 'AppControllers\CategoriesController@createNewCategory');
		 $router->post('/img', 'AppControllers\CategoriesController@updateCategoryImage');
		 $router->put('/', 'AppControllers\CategoriesController@updateCategory');
        
    });
	
	$router->group(['prefix' => 'units'], function ($router){

         $router->get('/', 'AppControllers\UnitsController@getAllUnits');
		 $router->post('/', 'AppControllers\UnitsController@createNewUnit');
        
    });
    
    $router->group(['prefix' => 'staffs'], function ($router){

         $router->get('/', 'AppControllers\StaffsController@getAllStaffs');
         $router->post('/login', 'AppControllers\StaffsController@login');
		 $router->post('/', 'AppControllers\StaffsController@createNewStaff');
		 $router->put('/', 'AppControllers\StaffsController@updateStaff');
        
    });
	
		$router->group(['prefix' => 'new_arr'], function ($router){

         $router->get('/', 'AppControllers\NewArrivalsController@getAllNew');
		 $router->post('/', 'AppControllers\NewArrivalsController@createNew');
		 $router->post('/del', 'AppControllers\NewArrivalsController@deleteNew');
        
    });
	
	
	$router->group(['prefix' => 'products'], function ($router){

         $router->get('/', 'AppControllers\ProductsController@getAllProducts');
		$router->get('/cat-unit', 'AppControllers\ProductsController@getCatAndUnit');
		$router->get('/group', 'AppControllers\ProductsController@getGroupProducts');
		 $router->post('/', 'AppControllers\ProductsController@createNewProduct');
		 $router->put('/', 'AppControllers\ProductsController@updateProduct');
		 $router->put('/discount', 'AppControllers\ProductsController@updateProductDiscount');
		 $router->post('/img/{p_id}', 'AppControllers\ProductsController@updateProductImage');
		 $router->post('/del', 'AppControllers\ProductsController@deleteProduct');
		$router->post('/rate/discount', 'AppControllers\ProductsController@updateProductRateByDiscount');
		
		
    });
	
	$router->group(['prefix' => 'customers'], function ($router){

         $router->get('/', 'AppControllers\CustomersController@getAllCustomers');
		 $router->post('/', 'AppControllers\CustomersController@createNewCustomer');
    });
    
    $router->group(['prefix' => 'settings'], function ($router){

         $router->get('/', 'AppControllers\SettingsController@getAllSettings');
         $router->get('/latest', 'AppControllers\SettingsController@getLastSettings');
		 $router->post('/', 'AppControllers\SettingsController@createNewSetting');
    });
	
	$router->group(['prefix' => 'orders'], function ($router){

        $router->get('/', 'AppControllers\OrdersController@getAllOrders');
        $router->get('/{phone_number}', 'AppControllers\OrdersController@getCustomersOrders');
		$router->get('items/{order_id}', 'AppControllers\OrdersController@getOrderItems');
		$router->post('/', 'AppControllers\OrdersController@createNewOrder');
		$router->post('/insert', 'AppControllers\OrdersController@insertOrderItem');
		$router->put('/items', 'AppControllers\OrdersController@updateOrderItems');
		$router->put('/items/discount', 'AppControllers\OrdersController@updateOrderItemsDiscount');
		$router->post('/items/del', 'AppControllers\OrdersController@deleteOrderItem');
		$router->put('/', 'AppControllers\OrdersController@updateOrder');
		
		
		
		
    });

});
