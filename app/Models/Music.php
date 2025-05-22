<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Music extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['title','link','description','status'];

    public function getLinkAttribute(){
        if(filter_var($this->attributes['link'], FILTER_VALIDATE_URL)){
            return $this->attributes['link'];
        }else{
            return url('file/show/'.$this->attributes['link']);
        }
    }

}
