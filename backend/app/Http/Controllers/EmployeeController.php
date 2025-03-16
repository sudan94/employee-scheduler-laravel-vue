<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
     public function index(){
        return EmployeeResource::collection(Employee::paginate(50));
     }

     public function store(Request $request)
     {
        $employee = Employee::create($request->all());
        return new EmployeeResource($employee);
     }

     public function update(Request $request, Employee $employee)
     {
        $employee->update($request->all());
        return new EmployeeResource($employee);
     }

     public function destroy(Employee $employee)
     {
        $employee->delete();
        return response()->json(['message' => 'Employee deleted'],204);
     }

     public function show(Employee $employee)
     {
        return new EmployeeResource($employee);
     }
}
