<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvitationGuestBook extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];

    public function invitation(){
        return $this->belongsTo(Invitation::class);
    }

    public function rsvp(){
        return $this->hasOne(InvitationRsvp::class,'invitation_guest_book_id','id');
    }
}
