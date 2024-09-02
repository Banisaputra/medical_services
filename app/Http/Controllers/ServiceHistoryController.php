<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceHistories;

class ServiceHistoryController extends Controller
{
    public function index() {
        $serviceHistory = ServiceHistories::all();

        return view('service_histories.index', compact('serviceHistory'));
    }
}
