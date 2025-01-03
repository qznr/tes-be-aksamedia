<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\DivisionResource;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DivisionController extends Controller
{
    public function index(Request $request)
    {
        $divisions = Division::when($request->name, function ($query, $name) {
            return $query->where('name', 'like', '%' . $name . '%');
        })->paginate(10);

        return response()->json([
            'status' => 'success',
            'message' => 'Divisions retrieved successfully',
            'data' => [
                'divisions' => DivisionResource::collection($divisions),
            ],
            'pagination' => [
                'total' => $divisions->total(),
                'per_page' => $divisions->perPage(),
                'current_page' => $divisions->currentPage(),
                'last_page' => $divisions->lastPage(),
                'from' => $divisions->firstItem(),
                'to' => $divisions->lastItem(),
            ],
        ]);
    }
}