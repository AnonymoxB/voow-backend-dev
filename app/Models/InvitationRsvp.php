<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvitationRsvp extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];


    public function invitation(){
        return $this->belongsTo(Invitation::class);
    }
    public function guestBook(){
        return $this->belongsTo(InvitationGuestBook::class,'invitation_guest_book_id','id');
    }
}
