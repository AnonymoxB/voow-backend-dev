<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvitationDetail extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];


    public function getOpeningAttribute()
    {
        return json_decode($this->attributes['opening']);
    }

    public function getHomeAttribute()
    {
        return json_decode($this->attributes['home']);
    }

    public function getCoupleAttribute()
    {
        return json_decode($this->attributes['couple']);
    }

    public function getDateAttribute()
    {
        return json_decode($this->attributes['date']);
    }

    public function getStoryAttribute()
    {
        return json_decode($this->attributes['story']);
    }

    public function getGalleryAttribute()
    {
        return json_decode($this->attributes['gallery']);
    }

    public function getGiftAttribute()
    {
        return json_decode($this->attributes['gift']);
    }

    public function getRsvpAttribute()
    {
        return json_decode($this->attributes['rsvp']);
    }

    public function getThanksAttribute()
    {
        return json_decode($this->attributes['thanks']);
    }

}
