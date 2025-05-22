<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemplateCategory extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];

    public function template(){
        return $this->hasMany(Template::class);
    }

}
