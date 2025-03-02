<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGroupMemberRequest;
use App\Http\Requests\UpdateGroupMemberRequest;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupMembersController extends Controller
{
    public function store (StoreGroupMemberRequest $request)
    {
        $validator = $request->validated();

        $group = Group::query()->findOrfail($validator['group_id']);
        $group->students()->attach($validator['user_id'], ['created_id' => now(), 'updated_id' => now()]);

        return response()->json(['message' => 'Group member added successfully.'], 201);
    }

    public function update(string $id, UpdateGroupMemberRequest $request)
    {
        $validator = $request->validated();

        $group = Group::query()->findOrfail($id);
        $group->students()->detach($validator['user_id']);

        return response()->json(['message' => 'Student update from group successfully.'], 200);
    }

    public function destroy(string $id,  Request $request)
    {
        $validator = $request->validated([
            'group_id' => 'required|exists:groups,id',
        ]);
        $group = Group::query()->findOrfail($validator['group_id']);
        $group->students()->detach($id);
        return response()->json(['message' => 'Student delete from group successfully.'], 200);
    }
}
