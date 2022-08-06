<?php


namespace App\Models\AppModels;


use Illuminate\Database\Eloquent\Model;

class UnitsModel extends  Model
{
    protected $table = 'units';

    protected $fillable = [
        "id",
        "unit_name",
        "created_at",
        "updated_at",
        "created_by"

    ];

}
