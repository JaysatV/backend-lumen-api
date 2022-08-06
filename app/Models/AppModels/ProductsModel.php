<?php


namespace App\Models\AppModels;


use Illuminate\Database\Eloquent\Model;

class ProductsModel extends  Model
{
    protected $table = 'products';

    protected $fillable = [
        "id",
        "product_code",
        "product_name",
		"product_name_ta",
        "product_cat",
        "product_unit",
        "unit_per",
        "product_rate",
        "product_discount",
        "product_stock",
        "visibility",
        "created_at",
        "updated_at",
        "created_by"

    ];

}
