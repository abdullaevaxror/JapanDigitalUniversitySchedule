<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Subject::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->get('search') . '%');
        }

        if ($request->has('sort')){
            $query->where('sort', $request->get('sort'));
        }

        $perPage = $request->get('per_page', 10);
        $subjects = $query->paginate($perPage);

        return response()->json($subjects);
    }

    public function show(Subject $subjects)
    {
        return response()->json($subjects);
    }

    public function create(Request $request, Subject $subjects)
    {
        $validator = $request->validate([
            'name' => 'required',
        ]);
        $subjects->update($validator);
        return response()->json(['message' => 'Subject updated successfully.']);
    }

    public function delete(Subject $subjects)
    {
        $subjects->delete();
        return response()->json(['message' => 'Subject deleted successfully.']);
    }
}
