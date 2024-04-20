<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
  
    protected $table = 'agent';
    protected $fillable = ['name', 'phone', 'user',];
    
}
?>