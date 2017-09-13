<?php

namespace App\Http\Controllers;

use App\Entities\Department;

class DepartmentController extends Controller
{
    public function all()
    {
        return response()->json(Department::all(), 200);
    }
}
