<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;
    protected $primaryKey = 'tenantID';
    protected $table = 'tenants';

    public $incrementing = false; // Set this to false to prevent auto-incrementing
    public function appointment()
    {
        return $this->hasMany(Appointment::class, 'tenantID');
    }

    public function propertyRentals()
    {
        return $this->hasMany(PropertyRental::class, 'tenantID');
    }
}
