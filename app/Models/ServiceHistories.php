<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MasterPatients;

class ServiceHistories extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'diagnosis', 'medical_prescription'];

    public function patient() {
        return $this->belongsTo(MasterPatients::class, 'patient_id');
    }

}
