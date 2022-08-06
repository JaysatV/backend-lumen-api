<?php


namespace App\Models\AppModels;


use Illuminate\Database\Eloquent\Model;

class SettingsModel extends  Model
{
    protected $table = 'settings';

    protected $fillable = [
        "id",
        "paf",
        "discount",
        "created_at",
        "updated_at",
        "created_by"

    ];

}