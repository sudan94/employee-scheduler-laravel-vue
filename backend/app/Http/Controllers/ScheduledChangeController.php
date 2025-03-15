<?php

namespace App\Http\Controllers;

use App\Models\ScheduledChange;
use Illuminate\Http\Request;

class ScheduledChangeController extends Controller
{
    public function store(Request $request)
    {
        ScheduledChange::create($request->all());
        return response()-> json(['message' => 'Scheduled changed Successfully']);
    }
}
