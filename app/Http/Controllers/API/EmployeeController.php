<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $employees = Employee::with('division')
            ->when($request->name, function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->when($request->division_id, function ($query, $divisionId) {
                return $query->where('division_id', $divisionId);
            })
            ->paginate(7);

        return response()->json([
            'status' => 'success',
            'message' => 'Employees retrieved successfully',
            'data' => [
                'employees' => EmployeeResource::collection($employees),
            ],
            'pagination' => [
                'total' => $employees->total(),
                'per_page' => $employees->perPage(),
                'current_page' => $employees->currentPage(),
                'last_page' => $employees->lastPage(),
                'from' => $employees->firstItem(),
                'to' => $employees->lastItem(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        // Validate the request data manually
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'position' => 'required|string|max:255',
            'division_id' => 'required|exists:divisions,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422); // 422 Unprocessable Entity - common for validation errors
        }

        // Create a new employee instance
        $employee = new Employee();
        $employee->name = $request->name;
        $employee->phone = $request->phone;
        $employee->position = $request->position;
        $employee->division_id = $request->division_id;

        // Handle image upload (if provided)
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('employees', 'public');
            $employee->image = Storage::url($imagePath);
        }

        $employee->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Employee created successfully',
        ], 201);
    }

    public function show(string $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'status' => 'error',
                'message' => 'Employee not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Employee retrieved successfully',
            'data' => new EmployeeResource($employee),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $employee = Employee::find($id);

        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'position' => 'required|string|max:255',
            'division_id' => 'required|exists:divisions,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors(),
                'request' => $request,
            ], 422); // 422 Unprocessable Entity
        }

        // Update Employee Attributes
        $employee->name = $request->name;
        $employee->phone = $request->phone;
        $employee->position = $request->position;
        $employee->division_id = $request->division_id;

        // Handle Image Update (if provided)
        if ($request->hasFile('image')) {
            // Delete the old image (if it exists)
            if ($employee->image) {
                Storage::disk('public')->delete(str_replace('/storage', '', $employee->image));
            }

            // Store the new image
            $imagePath = $request->file('image')->store('employees', 'public');
            $employee->image = Storage::url($imagePath);
        }

        $employee->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Employee updated successfully',
        ]);
    }

    public function destroy(string $id)
    {
        try {
            $employee = Employee::find($id);

            if (!$employee) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Employee not found',
                ], 404);
            }

            if ($employee->image) {
                Storage::disk('public')->delete(str_replace('/storage', '', $employee->image));
            }

            $employee->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Employee deleted successfully',
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Database error: ' . $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
}