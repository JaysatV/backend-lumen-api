<?php


namespace App\Models\AppModels;


use Illuminate\Database\Eloquent\Model;

class StaffsModel extends  Model
{
    protected $table = 'staffs';

    protected $fillable = [
        "id",
        "staff_name",
        "staff_password",
        "designation",
        "created_at",
        "updated_at",
        "created_by"

    ];

}
