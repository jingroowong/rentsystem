<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $primaryKey = 'agentID'; // Specify the primary key field


    // Define a relationship with Wallet model
    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'agentID');
    }

        // Define a relationship with Property model
        public function properties()
        {
            return $this->hasMany(Property::class, 'agentID');
        }
    
}
