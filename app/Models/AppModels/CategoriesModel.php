<?php


namespace App\Models\AppModels;


use Illuminate\Database\Eloquent\Model;

class CategoriesModel extends  Model
{
    protected $table = 'categories';

    protected $fillable = [
        "id",
        "cat_name",
        "visibility",
        "created_at",
        "updated_at",
        "created_by"

    ];

}
