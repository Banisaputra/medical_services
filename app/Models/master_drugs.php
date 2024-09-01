<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class master_drugs extends Model
{
    use HasFactory;

    protected $fillable = ['drug_name', 'remark'];
}
