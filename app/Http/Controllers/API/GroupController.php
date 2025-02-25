<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $query = Group::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' .  $request->get('search') . '%');
        }

        if ($request->has('sort')) {
            $query->where('sort', $request->get('group'));
        }

        $perPage = $request->get('per_page', 10);
        $group = $query->paginate($perPage);

        return response()->json($group);
    }
    public function show(Group $group)
    {
        return response()->json($group);
    }

    public function create(Request $request,  Group $group)
    {
        $validator = $request->validate([
            'name' => 'required',
        ]);
        $group->update($validator);
        return response()->json(['message' => 'Group updated successfully.']);
    }

    public function delete(Group $group)
    {
        $group->delete();
        return response()->json(['message' => 'Group deleted successfully.']);
    }
}
