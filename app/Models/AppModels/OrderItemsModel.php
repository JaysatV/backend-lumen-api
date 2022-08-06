<?php


namespace App\Models\AppModels;


use Illuminate\Database\Eloquent\Model;

class OrderItemsModel extends  Model
{
   
	protected $connection = "mysql_order_items";
    protected $fillable = [
        "id",
        "item_name",
        "item_rate",
        "item_discount",
        "item_discount_total",
        "item_quantity",
        "item_total",
		"created_at",
		"updated_at",
		"created_by"

    ];

}
