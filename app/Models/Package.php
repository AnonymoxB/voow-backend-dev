<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getDescriptionAttribute()
    {
        $arrayDescription =  json_decode($this->attributes['description']);
        if($arrayDescription == null){
            return $this->attributes['description'];
        }else{
            return $arrayDescription;
        }
    }
}
