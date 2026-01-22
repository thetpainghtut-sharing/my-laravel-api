<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Resources\EmployeeResource;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with('department')->get();
        // return $employees;
        return EmployeeResource::collection($employees);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:100|min:3",
            "email" => "required|string|email|max:255|unique:users",
            "gender" => "required|string|max:100|min:3",
            "phone" => "required|string|max:100|min:3",
            "profile" => "image|mimes:jpeg,png,jpg,gif|max:2048",
            "department" => "required|exists:departments,id"
        ]);

        if ($request->hasFile('profile')) {
            // 'store' method saves the file to storage/app/public/employees
            // It returns the path (e.g., "employees/xyz123.jpg")
            $path = $request->file('profile')->store('employees', 'public');
        }

        $employee = new Employee;
        $employee->eid = uniqid(); // 00001 format -> please try
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->gender = $request->gender;
        $employee->phone = $request->phone;
        $employee->profile = $path;
        $employee->department_id = $request->department;
        $employee->save();

        return new EmployeeResource($employee);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return new EmployeeResource($employee);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
