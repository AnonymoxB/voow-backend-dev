<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invitation extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function music()
    {
        return $this->belongsTo(Music::class);
    }

    public function invitationEn()
    {
        return $this->hasOne(Invitation::class,'parent_id','id');
    }

    public function detail(){
        return $this->hasOne(InvitationDetail::class);
    }

    public function images(){
        return $this->hasMany(InvitationImage::class);
    }
}
