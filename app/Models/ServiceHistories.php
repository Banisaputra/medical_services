<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceHistories extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'diagnosis', 'medical_prescription'];
}
