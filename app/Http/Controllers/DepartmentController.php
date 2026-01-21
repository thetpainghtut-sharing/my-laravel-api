<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::all();
        return $departments;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "string"
        ]);

        $department = new Department;
        $department->name = $request->name;
        $department->save();

        return $department;
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        return $department;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            "name" => "string"
        ]);

        $department->name = $request->name;
        $department->save();

        return $department;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return null;
    }
}
