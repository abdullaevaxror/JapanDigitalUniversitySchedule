<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRoleUserRequest;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Subject::query();
        if ($request->has('search')) {
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

    public function create(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
        ]);
        Subject::query()->create([$validator]);
        return response()->json(['message' => 'Subject created successfully.']);
    }

    public function update (UpdateRoleUserRequest $request, $subject)
    {
        $validator = $request->validated();
        $subject->update($validator);
        return response()->json(['message' => 'Subject updated successfully.']);
    }

    public function delete(Subject $subjects)
    {
        $subjects->delete();
        return response()->json(['message' => 'Subject deleted successfully.']);
    }
}
