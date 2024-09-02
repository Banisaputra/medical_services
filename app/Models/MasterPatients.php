<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPatients extends Model
{
    use HasFactory;

    protected $fillable = ['patient_name', 'patient_address'];
    
}
