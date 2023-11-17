<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;
    protected $primaryKey = 'tenantID';
 
    public $incrementing = false; // Set this to false to prevent auto-incrementing
    public function appointment()
    {
        return $this->hasMany(Appointment::class, 'appID', 'appID');
    }
}
