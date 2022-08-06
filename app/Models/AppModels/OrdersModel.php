<?php


namespace App\Models\AppModels;


use Illuminate\Database\Eloquent\Model;

class OrdersModel extends  Model
{
    protected $table = 'orders';

    protected $fillable = [
        "id",
        "customer_id",
        "customer_name",
        "customer_email",
        "delivery_address",
        "items_count",
        "items_total",
        "discount_percent",
        "discount_amount",
		"paf_charges",
		"total_amount",
		"status",
		"is_paid",
		"tr_name",
		"tr_lr",
		"created_at",
		"updated_at",
		"created_by"

    ];

}
