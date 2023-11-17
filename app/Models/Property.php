<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

  
    protected $primaryKey = 'propertyID';

    public $incrementing = false; // Set this to false to prevent auto-incrementing

public function propertyPhotos()
{
    return $this->hasMany(PropertyPhoto::class, 'propertyID');
}

public function propertyFacilities()
{
    return $this->hasMany(PropertyFacility::class, 'propertyID');
}
public function agent()
{
    return $this->belongsTo(Agent::class, 'agentID');
}

public function appointment()
{
    return $this->hasMany(Appointment::class, 'appID', 'appID');
}
}
