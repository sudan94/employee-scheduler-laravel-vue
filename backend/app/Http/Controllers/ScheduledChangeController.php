<?php

namespace App\Http\Controllers;

use App\Models\ScheduledChange;
use App\Models\Employee;
use Illuminate\Http\Request;

class ScheduledChangeController extends Controller
{
    public function store(Request $request)
    {
        $employee = Employee::find($request->employee_id);
        $data = $request->all();
        $data['old_value'] = $employee->{$request->field};
        ScheduledChange::create($data);
        return response()-> json(['message' => 'Scheduled changed Successfully']);
    }

    public function index()
    {
        return ScheduledChange::join('employees', 'scheduled_changes.employee_id', '=', 'employees.id')
            ->select(
                'employees.id',
                'employees.name',
                'scheduled_changes.field',
                'scheduled_changes.old_value',
                'scheduled_changes.new_value',
                'scheduled_changes.processed_at',
                'scheduled_changes.effective_date'
            )
            ->paginate(10);
    }
}
