<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Blog extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function blogCategory(){
        return $this->belongsTo(BlogCategory::class);
    }

    public function getImageAttribute(){
        if(filter_var($this->attributes['image'], FILTER_VALIDATE_URL)){
            return $this->attributes['image'];
        }else{
            return url('file/show/'.$this->attributes['image']);

        }
    }
}
