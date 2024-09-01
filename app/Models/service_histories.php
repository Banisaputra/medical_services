<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class service_histories extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'diagnosis', 'medical_prescription'];
}
