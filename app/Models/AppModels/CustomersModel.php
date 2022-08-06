<?php


namespace App\Models\AppModels;


use Illuminate\Database\Eloquent\Model;

class CustomersModel extends  Model
{
    protected $table = 'customers';

    protected $fillable = [
        "id",
        "customer_name",
        "email_id",
        "phone_number",
        "address",
        "created_at",
        "updated_at",
        "created_by"

    ];

}
