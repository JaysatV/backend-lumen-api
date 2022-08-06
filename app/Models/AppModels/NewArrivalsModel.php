<?php


namespace App\Models\AppModels;


use Illuminate\Database\Eloquent\Model;

class NewArrivalsModel extends  Model
{
    protected $table = 'new_arrivals';

    protected $fillable = [
        "id",
        "p_code",
        "created_at",
        "updated_at",
        "created_by"

    ];

}
